@extends('user.layouts.app')
@section('content')
@include('user.common.alert')
<style>
.main-containt:has(.rc-page) {
    padding: 28px 32px 56px !important;
    background: #f4f6fb;
}
.rc-page {
    position: relative;
    font-family: "Gilroy-Medium", "Segoe UI", sans-serif;
    color: #1f2430;
}
.rc-title {
    margin: 4px 0 22px;
    font-size: 20px;
    line-height: 1.3;
    font-weight: 600;
    color: #1c2230;
    font-family: "Gilroy-Semibold", "Gilroy-Medium", "Segoe UI", sans-serif;
}
.rc-grid {
    display: flex;
    align-items: flex-start;
    gap: 22px;
    flex-wrap: wrap;
}
.rc-card {
    background: #fff;
    border: 1px solid #eef0f4;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(28, 34, 48, 0.04);
    padding: 22px 22px 20px;
}
.rc-details { width: 392px; max-width: 100%; flex: 0 0 392px; }
.rc-plans-wrap { width: 540px; max-width: 100%; flex: 0 0 540px; }
.rc-card-title {
    margin: 0 0 18px;
    font-size: 15px;
    font-weight: 700;
    color: #635bfe;
    font-family: "Gilroy-Semibold", "Gilroy-Medium", "Segoe UI", sans-serif;
}
.rc-field { margin-bottom: 14px; }
.rc-label {
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #8b93a7;
}
.rc-control {
    display: block;
    width: 100%;
    height: 44px;
    padding: 0 12px;
    border: 1px solid #e4e7ee !important;
    border-radius: 8px !important;
    background: #fff !important;
    color: #1f2430 !important;
    font-size: 14px;
    line-height: 44px;
    box-shadow: none !important;
    outline: none;
    appearance: auto;
    -webkit-appearance: menulist;
}
.rc-control:focus {
    border-color: #635bfe !important;
    box-shadow: 0 0 0 3px rgba(99, 91, 254, 0.12) !important;
}
.rc-control.is-filled {
    background: #e8f0ff !important;
    border-color: #d5e2fb !important;
}
input.rc-control[type="number"]::-webkit-outer-spin-button,
input.rc-control[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input.rc-control[type="number"] { -moz-appearance: textfield; appearance: textfield; }
.rc-fetch {
    display: block;
    width: 100%;
    margin: 6px 0 12px;
    padding: 8px 0;
    border: 0;
    background: transparent;
    color: #635bfe;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    font-family: "Gilroy-Semibold", "Gilroy-Medium", "Segoe UI", sans-serif;
}
.rc-fetch:hover { color: #4f46e5; }
.rc-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 46px;
    border: 0 !important;
    border-radius: 8px !important;
    background: #635bfe !important;
    color: #fff !important;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    font-family: "Gilroy-Semibold", "Gilroy-Medium", "Segoe UI", sans-serif;
    box-shadow: 0 6px 16px rgba(99, 91, 254, 0.28);
}
.rc-submit:hover { background: #564ff0 !important; }
.rc-submit:disabled { opacity: 0.7; cursor: not-allowed; }
.rc-plans {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}
.rc-plan {
    border: 1px solid #e6e8ef;
    border-radius: 10px;
    background: #fff;
    padding: 14px 12px 12px;
    cursor: pointer;
    text-align: left;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.rc-plan:hover { border-color: #c9c6ff; }
.rc-plan.is-active {
    border-color: #635bfe;
    box-shadow: 0 0 0 1px #635bfe;
}
.rc-plan-amt {
    margin: 0 0 4px;
    font-size: 15px;
    font-weight: 700;
    color: #1f2430;
    font-family: "Gilroy-Semibold", "Gilroy-Medium", "Segoe UI", sans-serif;
}
.rc-plan-meta {
    margin: 0;
    font-size: 12px;
    line-height: 1.35;
    color: #9aa3b5;
}
.rc-empty {
    margin: 8px 0 0;
    text-align: center;
    font-size: 13px;
    color: #9aa3b5;
}
.rc-toast {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 20;
    width: min(420px, 100%);
}
.rc-toast-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 13px;
    line-height: 1.4;
}
.rc-toast-item.is-ok {
    background: #e7f6ec;
    color: #1f7a45;
    border: 1px solid #cfeedd;
}
.rc-toast-item.is-error {
    background: #fdecec;
    color: #b42318;
    border: 1px solid #f8d0d0;
}
.rc-toast-x {
    margin-left: auto;
    border: 0;
    background: transparent;
    color: inherit;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
    padding: 0 2px;
}
@media (max-width: 1100px) {
    .rc-details, .rc-plans-wrap { flex: 1 1 100%; width: 100%; }
    .rc-toast { position: static; width: 100%; margin-bottom: 14px; }
}
</style>

<div class="rc-page">
    <div id="recharge-toast" class="rc-toast"></div>
    <h1 class="rc-title">{{ __('Recharge') }} ({{ __('Mobile') }} / DTH)</h1>
    <div class="rc-grid">
        <div class="rc-card rc-details">
            <h2 class="rc-card-title">{{ __('Recharge Details') }}</h2>
            <form id="recharge-form">
                @csrf
                <div class="rc-field">
                    <label class="rc-label" for="recharge-operator">{{ __('Operator') }}</label>
                    <select class="rc-control" name="operator" id="recharge-operator" required>
                        <option value="">{{ __('Loading...') }}</option>
                    </select>
                </div>
                <div class="rc-field">
                    <label class="rc-label" for="recharge-mobile">{{ __('Mobile Number') }}</label>
                    <input type="tel" class="rc-control" name="mobile" id="recharge-mobile" placeholder="{{ __('10-digit mobile number') }}" maxlength="10" inputmode="numeric">
                </div>
                <div class="rc-field">
                    <label class="rc-label" for="recharge-amount">{{ __('Amount') }} (₹)</label>
                    <input type="number" class="rc-control" name="amount" id="recharge-amount" placeholder="299" min="10" value="299">
                </div>
                <button type="button" class="rc-fetch" id="fetch-plans">{{ __('Fetch Plans') }}</button>
                <button type="button" class="rc-submit" id="recharge-btn">{{ __('Recharge') }}</button>
            </form>
        </div>
        <div class="rc-card rc-plans-wrap">
            <h2 class="rc-card-title">{{ __('Plans') }}</h2>
            <p id="plan-list-empty" class="rc-empty d-none">{{ __('Enter number and click Fetch Plans to see plans.') }}</p>
            <div class="rc-plans" id="plan-list">
                <button type="button" class="rc-plan plan-card" data-amount="299">
                    <p class="rc-plan-amt">₹ 299</p>
                    <p class="rc-plan-meta">2GB/day, 28 days</p>
                </button>
                <button type="button" class="rc-plan plan-card" data-amount="399">
                    <p class="rc-plan-amt">₹ 399</p>
                    <p class="rc-plan-meta">2GB/day, 56 days</p>
                </button>
                <button type="button" class="rc-plan plan-card" data-amount="499">
                    <p class="rc-plan-amt">₹ 499</p>
                    <p class="rc-plan-meta">Unlimited, 28 days</p>
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('public/user/customs/js/rechargeService.js') }}"></script>
<script>
(function(){
    var getOperatorsUrl='{{ url("recharge/get-operators") }}', doRechargeUrl='{{ url("recharge/do") }}';
    var csrfToken=document.querySelector('#recharge-form input[name="_token"]').value;
    var mobileInput=document.getElementById('recharge-mobile');
    function showToast(msg,type){
        var el=document.getElementById('recharge-toast');
        el.innerHTML='';
        var box=document.createElement('div');
        box.className='rc-toast-item '+(type==='error'?'is-error':'is-ok');
        var text=document.createElement('span');
        text.textContent=msg;
        var close=document.createElement('button');
        close.type='button';
        close.className='rc-toast-x';
        close.setAttribute('aria-label','Close');
        close.textContent='×';
        close.addEventListener('click',function(){ el.innerHTML=''; });
        box.appendChild(text);
        box.appendChild(close);
        el.appendChild(box);
        setTimeout(function(){ if(el.contains(box)) el.innerHTML=''; },4000);
    }
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
    mobileInput.addEventListener('input',function(){
        this.value=this.value.replace(/\D/g,'').slice(0,10);
        this.classList.toggle('is-filled', this.value.length>0);
    });
    document.getElementById('fetch-plans').addEventListener('click',function(){
        var m=mobileInput.value.trim();
        if(m.length!==10){ showToast('Enter valid 10-digit mobile number.','error'); return; }
        document.getElementById('plan-list-empty').classList.add('d-none');
        document.getElementById('plan-list').classList.remove('d-none');
        showToast('Select an amount below or enter a custom amount above.');
    });
    document.querySelectorAll('.plan-card').forEach(function(el){
        el.addEventListener('click',function(){
            document.querySelectorAll('.plan-card').forEach(function(c){ c.classList.remove('is-active'); });
            this.classList.add('is-active');
            document.getElementById('recharge-amount').value=this.dataset.amount;
            showToast('Select an amount below or enter a custom amount above.');
        });
    });
    document.getElementById('recharge-btn').addEventListener('click',async function(){
        var op=document.getElementById('recharge-operator').value, opOpt=document.getElementById('recharge-operator').selectedOptions[0];
        var opName=opOpt?opOpt.dataset.name||opOpt.textContent:op, mobile=mobileInput.value.trim(), amount=document.getElementById('recharge-amount').value;
        if(!op){ showToast('Please select an operator.','error'); return; }
        if(mobile.length!==10){ showToast('Enter valid 10-digit mobile number.','error'); return; }
        if(!amount||parseFloat(amount)<10){ showToast('Enter valid amount (min ₹10).','error'); return; }
        var btn=this; btn.disabled=true; btn.textContent='Processing...';
        try{
            var r=await RechargeService.doRecharge(doRechargeUrl,csrfToken,{operator:op,operator_name:opName,mobile:mobile,amount:parseFloat(amount)});
            if(r.success) showToast(r.message||'Recharge successful!'); else showToast(r.message||'Recharge failed.','error');
        }catch(e){ showToast('Recharge request failed. Please try again.','error'); }
        finally{ btn.disabled=false; btn.textContent='{{ __("Recharge") }}'; }
    });
})();
</script>
@endpush
@endsection
