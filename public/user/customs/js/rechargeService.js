"use strict";
var RechargeService=(function(){
    async function getOperators(getOperatorsUrl,csrfToken){
        try{
            var response=await fetch(getOperatorsUrl,{method:"POST",headers:{"X-CSRF-TOKEN":csrfToken,"Accept":"application/json","Content-Type":"application/json"},body:JSON.stringify({})});
            var data=await response.json();
            if(!response.ok) return {success:false,message:data.message||"Failed to load operators."};
            return {success:true,data:data.data||[],message:data.message};
        }catch(err){ return {success:false,message:err.message||"Failed to load operators."}; }
    }
    async function doRecharge(doRechargeUrl,csrfToken,payload){
        try{
            var response=await fetch(doRechargeUrl,{method:"POST",headers:{"X-CSRF-TOKEN":csrfToken,"Accept":"application/json","Content-Type":"application/json"},body:JSON.stringify(payload)});
            var data=await response.json();
            if(!response.ok) return {success:false,message:data.message||"Recharge request failed."};
            return {success:!!data.success,status:data.status,message:data.message||(data.success?"Recharge successful!":"Recharge failed."),reference_id:data.reference_id};
        }catch(err){ return {success:false,message:err.message||"Recharge request failed. Please try again."}; }
    }
    return {getOperators:getOperators,doRecharge:doRecharge};
})();
