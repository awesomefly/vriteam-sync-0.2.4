/****************************************************************************
* 版权所有  ： (C)2010 深圳市迅雷网络技术有限公司
* 设计部门  ： 迅雷会员帐号部门 
* 系统名称  : 
* 文件名称  : FinalRequestProcessor.cpp
* 内容摘要  : 
* 当前版本  : 1.0
* 作    者  : 陈泉
* 设计日期  : 2012年2月2日
* 修改记录  :
* 修改记录  ：
  *1）、版本号

       *日  期：
       *修改人：
       *摘  要：  
****************************************************************************/
#include "ErrCode.h"
#include "Stat.h"
#include "FinalRequestProcessor.h"
#include "CreateSessionTxn.h"
#include "CreateResponse.h"
#include "SetDataResponse.h"
#include "NIOServerCnxn.h"
#include "ReplyHeader.h"
#include "RequestHeader.h"
#include "GetDataRequest.h"
#include "GetDataResponse.h"
#include "SetACLResponse.h"
#include "ExistsRequest.h"
#include "ExistsResponse.h"
#include "GetACLRequest.h"
#include "GetACLResponse.h"
#include "GetChildrenRequest.h"
#include "GetChildrenResponse.h"

#include <typeinfo>

IMPL_LOGGER(CFinalRequestProcessor, logger);
void CFinalRequestProcessor::processRequest(CRequest request)
{
	LOG4CPLUS_TRACE(logger, "CFinalRequestProcessor::processRequest");

        CProcessTxnResult rc ;

        if (request.txn!= NULL || request.type == OpCode::closeSession) {
            rc = zks->getZKDatabase()->processTxn(request.hdr, request.txn);
            if (request.type == OpCode::createSession) {
                if (typeid(*(request.txn)) == typeid(CreateSessionTxn)) {
                    CreateSessionTxn* cst = (CreateSessionTxn*)(request.txn);
                    zks->sessionTracker->addSession(request.sessionId, cst->getTimeOut());
                } else {
    				 LOG4CPLUS_WARN(logger, "unknow txn class type !!  ");
                }
            } else if (request.type == OpCode::closeSession) {
                zks->sessionTracker->removeSession(request.sessionId);
            }
        }

        if (request.cnxn == NULL) {
        	//expired  do not reply...
        	if(request.txn != NULL) 
        		delete request.txn;
            return;
        }

	    CNIOServerCnxn* cnxn = request.cnxn;

        int err=0;
        CRecord* rsp = NULL;
        bool closeSession = false;
        
        if ( request.hdr.getType() == OpCode::error) {
        	err = rc.err;
        	goto END;
        }
	    
		try{
			switch (request.type) {
	            case OpCode::ping: {
	            	zks->sessionTracker->updateSession(request.sessionId);
                    cnxn->sendResponse(  CReplyHeader(-2 , zks->getZKDatabase()->getDataTreeLastProcessedZxid(), 0) 
                    				    , NULL 
                    				   , "response");
	                goto FREE;
	            }
	            case OpCode::createSession: {
	            	/*zks.serverStats().updateLatency(request.createTime);

	                lastOp = "SESS";
	                ((CnxnStats)cnxn.getStats()).updateForResponse(request.cxid, request.zxid, lastOp,
	                        request.createTime, System.currentTimeMillis());*/

	                cnxn->finishSessionInit(true);
	                goto FREE;
	            }
	            case OpCode::create: {
	            	//lastOp = "CREA";
	                rsp = new CreateResponse(rc.path);
	                err = rc.err;
	                break;
	            }
	            case OpCode::delete_: {
	                err = rc.err;
	                break;
	            }
	            case OpCode::setData: {
	            	rsp = new SetDataResponse(rc.stat);
					err = rc.err;
	                break;
	            }
	            case OpCode::setACL: {
	            	rsp = new SetACLResponse(rc.stat);
	                err = rc.err;
	                break;
	            }
	            case OpCode::closeSession: {
	                //closeSession = true;
                	err = rc.err;
	                break;
	            }
	            case OpCode::sync: {
	                break;
	            }
	            case OpCode::exists: {
	            	CBinMsgRow in;
					int len = request.request.length();
					int ret = in.Decode(request.request.c_str() , len);
					if( ret != 0 ){
			            LOG4CPLUS_ERROR(logger,"request.request Decode fail!  len:"<<len);
	                	goto FREE;
					}
			        CRequestHeader h ;
				    if(h.deserialize(in, "header")== -1)
				    {
				    	 LOG4CPLUS_ERROR(logger,"CRequestHeader deserialize fail!!");
				    }
					LOG4CPLUS_DEBUG(logger,"header type:"<<h.getType()<<" header xid:"<<h.getXid() );



	                CExistsRequest existsRequest;
					existsRequest.deserialize(in,"request");
	                LOG4CPLUS_DEBUG(logger,"CExistsRequest path:"<<existsRequest.getPath()<<" watch:"<<existsRequest.getWatch());

               		CStatPersisted stat = zks->getZKDatabase()->statNode(existsRequest.getPath(),
               								existsRequest.getWatch() ? request.cnxn : NULL);
	                rsp = new CExistsResponse(stat);

	                break;
	            }
	            case OpCode::getData: {
	            	CBinMsgRow in;
					int len = request.request.length();
					int ret = in.Decode(request.request.c_str() , len);
					if( ret != 0 ){
			            LOG4CPLUS_ERROR(logger,"request.request Decode fail!  len:"<<len);
	                	goto FREE;
					}
			        CRequestHeader h ;
				    if(h.deserialize(in, "header")== -1)
				    {
				    	 LOG4CPLUS_ERROR(logger,"CRequestHeader deserialize fail!!");
				    }
					LOG4CPLUS_DEBUG(logger,"header type:"<<h.getType()<<" header xid:"<<h.getXid() );



	                GetDataRequest getDataRequest;
					getDataRequest.deserialize(in,"request");
	                LOG4CPLUS_DEBUG(logger,"GetDataRequest path:"<<getDataRequest.getPath()<<" watch:"<<getDataRequest.getWatch());

	                CDataNode* n = zks->getZKDatabase()->getNode(getDataRequest.getPath());
	                if (n == NULL) {
	                	err = CErrCode::NONODE;
	                    LOG4CPLUS_WARN(logger,"NoNodeException()");
	                    break;
	                }
	                long aclL;
	                n->lockSelf();
	                aclL = n->acl;
	                n->unlockSelf();
	                
	                if( CPrepRequestProcessor::checkACL(zks, zks->getZKDatabase()->convertLong(aclL),
	                       				 Perms::READ, request.authInfo) != 0 )
	                {
                        err = CErrCode::NOAUTH;
                		LOG4CPLUS_WARN(logger,"checkACL failed!");
                		break;
	                }
	                CStatPersisted stat;
	                string b = zks->getZKDatabase()->getData(getDataRequest.getPath(), stat,//NULL);
	                        getDataRequest.getWatch() ? request.cnxn : NULL);
	                rsp = new GetDataResponse(b, stat);
	                break;
	            }
	            case OpCode::setWatches: {
	                break;
	            }
	            case OpCode::getACL: {
	                CBinMsgRow in;
					int len = request.request.length();
					int ret = in.Decode(request.request.c_str() , len);
					if( ret != 0 ){
			            LOG4CPLUS_ERROR(logger,"request.request Decode fail!  len:"<<len);
	                	goto FREE;
					}
			        CRequestHeader h ;
				    if(h.deserialize(in, "header")== -1)
				    {
				    	 LOG4CPLUS_ERROR(logger,"CRequestHeader deserialize fail!!");
				    }
					LOG4CPLUS_DEBUG(logger,"header type:"<<h.getType()<<" header xid:"<<h.getXid() );

	                GetACLRequest getACLRequest;
					getACLRequest.deserialize(in,"request");
	                LOG4CPLUS_DEBUG(logger,"GetACLRequest path:"<<getACLRequest.getPath() );

	                CStatPersisted stat;
	                list<ACL> acl = zks->getZKDatabase()->getACL(getACLRequest.getPath(), stat);
	                rsp = new GetACLResponse(acl, stat);
	                break;
	            }
	            case OpCode::getChildren: {
	                CBinMsgRow in;
					int len = request.request.length();
					int ret = in.Decode(request.request.c_str() , len);
					if( ret != 0 ){
			            LOG4CPLUS_ERROR(logger,"request.request Decode fail!  len:"<<len);
	               		 goto FREE;
					}
			        CRequestHeader h ;
				    if(h.deserialize(in, "header")== -1)
				    {
				    	 LOG4CPLUS_ERROR(logger,"CRequestHeader deserialize fail!!");
				    }
					LOG4CPLUS_DEBUG(logger,"header type:"<<h.getType()<<" header xid:"<<h.getXid() );

	                GetChildrenRequest getChildrenRequest ;
                	getChildrenRequest.deserialize(in,"request");
	                LOG4CPLUS_DEBUG(logger,"GetChildrenRequest path:"<<getChildrenRequest.getPath()<<" watch:"<<getChildrenRequest.getWatch());

	                CDataNode* n = zks->getZKDatabase()->getNode(getChildrenRequest.getPath());
	                if (n == NULL) {
	                	err = CErrCode::NONODE;
	                    LOG4CPLUS_WARN(logger,"NoNodeException()");
	                    break;
	                }
	                long aclL;
	                n->lockSelf();
	                aclL = n->acl;
	                n->unlockSelf();
	                
	                if( CPrepRequestProcessor::checkACL(zks, zks->getZKDatabase()->convertLong(aclL),
	                       				 Perms::READ, request.authInfo) != 0 )
	                {
                        err = CErrCode::NOAUTH;
                		LOG4CPLUS_WARN(logger,"checkACL failed!");
                		break;
	                }

            		CStatPersisted stat;
	                list<string> children = zks->getZKDatabase()->getChildren(
	                        getChildrenRequest.getPath(), stat,
	                        getChildrenRequest.getWatch() ? request.cnxn : NULL);
	                        
	                rsp = new GetChildrenResponse(children);
	                break;
	            }
	            case OpCode::getChildren2: {
	                break;
	            }
	         }//switch
	      }catch(CErrCode::Code e){
	      		LOG4CPLUS_ERROR(logger, "exception:"<<e);
         		err = e;
	      }

		END:
		{
	        CReplyHeader hdr(request.cxid, request.zxid, err);
			LOG4CPLUS_TRACE(logger, "xid:"<<request.cxid<<" zixd::"<<request.zxid<<" err:"<<err);

	        cnxn->sendResponse(hdr, rsp, "response");
		}        
		FREE:
		{
	        if( rsp != NULL ){
	        	delete rsp;
	        }else if(request.txn != NULL){
	        	delete request.txn;
	        }else if (closeSession) {
	            cnxn->sendCloseSession();
	        }
        }
 
}


