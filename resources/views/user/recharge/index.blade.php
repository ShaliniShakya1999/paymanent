@extends('user.layouts.app')
@push('css')
<style>
#recharge-form .form-control, #recharge-form .form-select {
    background-color: #fff; border: 1px solid #dee2e6; color: #212529;
    padding: 0.5rem 0.75rem; font-size: 1rem; min-height: 38px;
}
#recharge-form .form-select { appearance: auto; -webkit-appearance: menulist; cursor: pointer; }
#recharge-form .form-control:focus, #recharge-form .form-select:focus {
    border-color: #635bfe; box-shadow: 0 0 0 0.2rem rgba(99, 91, 254, 0.25); outline: 0;
}
#recharge-form .form-select option { background: #fff; color: #212529; }
</style>
@endpush
@section('content')
@include('user.common.alert')
<div class="container-fluid py-4">
    <h1 class="h4 fw-semibold text-dark mb-4">{{ __('Recharge') }} ({{ __('Mobile') }} / DTH)</h1>
    <div class="row">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h2 class="h6 fw-bold text-primary mb-3">{{ __('Recharge Details') }}</h2>
                    <form id="recharge-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Operator') }}</label>
                            <select class="form-select" name="operator" id="recharge-operator" required>
                                <option value="">{{ __('Loading...') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Mobile Number') }}</label>
                            <input type="tel" class="form-control" name="mobile" id="recharge-mobile" placeholder="{{ __('10-digit mobile number') }}" maxlength="10">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Amount') }} (₹)</label>
                            <input type="number" class="form-control" name="amount" id="recharge-amount" placeholder="e.g. 299" min="10" value="299">
                        </div>
                        <button type="button" class="btn btn-outline-primary w-100 mb-2" id="fetch-plans">{{ __('Fetch Plans') }}</button>
                        <button type="button" class="btn btn-primary w-100" id="recharge-btn">{{ __('Recharge') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h2 class="h6 fw-bold text-primary mb-3">{{ __('Plans') }}</h2>
                    <div id="plan-list-empty" class="text-center py-4 text-muted small">{{ __('Enter number and click Fetch Plans to see plans.') }}</div>
                    <div class="row g-2 d-none" id="plan-list">
                        <div class="col-sm-6 col-md-4"><div class="card border shadow-sm rounded-3 p-3 plan-card" data-amount="299" style="cursor:pointer"><p class="fw-bold mb-1">₹ 299</p><p class="small text-muted mb-0">2GB/day, 28 days</p></div></div>
                        <div class="col-sm-6 col-md-4"><div class="card border shadow-sm rounded-3 p-3 plan-card" data-amount="399" style="cursor:pointer"><p class="fw-bold mb-1">₹ 399</p><p class="small text-muted mb-0">2GB/day, 56 days</p></div></div>
                        <div class="col-sm-6 col-md-4"><div class="card border shadow-sm rounded-3 p-3 plan-card" data-amount="499" style="cursor:pointer"><p class="fw-bold mb-1">₹ 499</p><p class="small text-muted mb-0">Unlimited, 28 days</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="recharge-toast" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

@push('js')
<script src="{{ asset('public/user/customs/js/rechargeService.js') }}"></script>
<script>
(function(){
    var getOperatorsUrl='{{ url("recharge/get-operators") }}', doRechargeUrl='{{ url("recharge/do") }}';
    var csrfToken=document.querySelector('#recharge-form input[name="_token"]').value;
    function showToast(msg,type){ var el=document.getElementById('recharge-toast'); var bg=type==='error'?'danger':'success'; el.innerHTML='<div class="alert alert-'+bg+' alert-dismissible fade show">'+msg+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'; setTimeout(function(){el.innerHTML='';},4000); }
    function setOperatorDropdown(operators){
        var sel=document.getElementById('recharge-operator');
        sel.innerHTML='<option value="">Select Operator</option>';
        if(Array.isArray(operators)){ operators.forEach(function(op){ var id=op.id||op.operator_id||op.value; var name=op.name||op.operator_name||op.text||String(id); if(id){ var o=document.createElement('option'); o.value=id; o.textContent=name; o.dataset.name=name; sel.appendChild(o); } }); }
        else if(operators&&typeof operators==='object'){ Object.keys(operators).forEach(function(id){ var name=operators[id]; if(typeof name==='string'){ var o=document.createElement('option'); o.value=id; o.textContent=name; o.dataset.name=name; sel.appendChild(o); } }); }
    }
    async function loadOperators(){
        var sel=document.getElementById('recharge-operator'); sel.innerHTML='<option value="">Loading...</option>';
        try{ var r=await RechargeService.getOperators(getOperatorsUrl,csrfToken); if(r.success&&r.data){ setOperatorDropdown(r.data); } else{ sel.innerHTML='<option value="">Failed to load operators</option>'; showToast(r.message||'Failed to load operators.','error'); } }
        catch(e){ sel.innerHTML='<option value="">Failed to load operators</option>'; showToast('Failed to load operators.','error'); }
    }
    loadOperators();
    document.getElementById('fetch-plans').addEventListener('click',function(){ var m=document.getElementById('recharge-mobile').value.trim(); if(m.length!==10){ showToast('Enter valid 10-digit mobile number.','error'); return; } document.getElementById('plan-list-empty').classList.add('d-none'); document.getElementById('plan-list').classList.remove('d-none'); showToast('Plans loaded. Select a plan or use Recharge.'); });
    document.querySelectorAll('.plan-card').forEach(function(el){ el.addEventListener('click',function(){ document.querySelectorAll('.plan-card').forEach(function(c){ c.classList.remove('border-primary'); }); this.classList.add('border-primary'); document.getElementById('recharge-amount').value=this.dataset.amount; }); });
    document.getElementById('recharge-btn').addEventListener('click',async function(){
        var op=document.getElementById('recharge-operator').value, opOpt=document.getElementById('recharge-operator').selectedOptions[0];
        var opName=opOpt?opOpt.dataset.name||opOpt.textContent:op, mobile=document.getElementById('recharge-mobile').value.trim(), amount=document.getElementById('recharge-amount').value;
        if(!op){ showToast('Please select an operator.','error'); return; }
        if(mobile.length!==10){ showToast('Enter valid 10-digit mobile number.','error'); return; }
        if(!amount||parseFloat(amount)<10){ showToast('Enter valid amount (min ₹10).','error'); return; }
        var btn=this; btn.disabled=true; btn.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        try{
            var r=await RechargeService.doRecharge(doRechargeUrl,csrfToken,{operator:op,operator_name:opName,mobile:mobile,amount:parseFloat(amount)});
            if(r.success) showToast(r.message||'Recharge successful!'); else showToast(r.message||'Recharge failed.','error');
        }catch(e){ showToast('Recharge request failed. Please try again.','error'); }
        finally{ btn.disabled=false; btn.innerHTML='{{ __("Recharge") }}'; }
    });
})();
</script>
@endpush
@endsection
