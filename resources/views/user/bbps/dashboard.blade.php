@extends('user.layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('css/bbps-dashboard.css') }}">
@endpush
@section('content')
<div class="bbps-page-wrap">
    <div class="bbps-main">
        <div class="bbps-hero bbps-animate-in">
            <h1 class="bbps-title">BBPS Bill Payment</h1>
            <p class="bbps-subtitle">Pay your utility bills instantly. Select a category or search for your biller.</p>
        </div>
        <div class="bbps-card-wrap mb-4 bbps-animate-in bbps-delay-1">
            <p class="bbps-section-label mb-2">Step 1</p>
            <h2 class="h5 fw-bold text-dark mb-3">Enter bill details</h2>
            <form id="bbpsBillForm" class="bbps-form">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-5">
                        <label class="form-label small fw-medium">Consumer Number</label>
                        <input type="text" class="form-control" id="consumerNumber" placeholder="Enter consumer/customer ID" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label small fw-medium">Operator / Biller</label>
                        <select class="form-select" id="billerSelect">
                            <option value="">Loading...</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100" id="fetchBillBtn">Fetch Bill</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bbps-card-wrap mb-4 d-none bbps-animate-in" id="billSummaryCard">
            <p class="bbps-section-label mb-2">Step 2</p>
            <h2 class="h5 fw-bold text-dark mb-3">Bill summary</h2>
            <div class="bbps-bill-summary">
                <div class="row g-3">
                    <div class="col-6 col-md-3"><p class="small text-muted mb-0">Customer name</p><p class="fw-semibold mb-0" id="summaryName">—</p></div>
                    <div class="col-6 col-md-3"><p class="small text-muted mb-0">Bill amount</p><p class="bbps-amount mb-0" id="summaryAmount">₹ 0</p></div>
                    <div class="col-6 col-md-3"><p class="small text-muted mb-0">Due date</p><p class="fw-semibold mb-0" id="summaryDueDate">—</p></div>
                    <div class="col-6 col-md-3"><p class="small text-muted mb-0">Biller</p><p class="fw-semibold mb-0" id="summaryBiller">—</p></div>
                </div>
            </div>
        </div>
        <div class="bbps-card-wrap mb-4 bbps-animate-in bbps-delay-3" id="paymentSection">
            <p class="bbps-section-label mb-2">Step 3</p>
            <h2 class="h5 fw-bold text-dark mb-3">Pay bill</h2>
            <button type="button" class="btn btn-primary px-5 py-3" id="payNowBtn">Pay Now</button>
        </div>
        <div class="bbps-card-wrap mb-4 d-none" id="successScreen">
            <div class="bbps-success-screen">
                <div class="bbps-success-icon">✓</div>
                <h3 class="h5 fw-bold text-dark mb-1">Payment successful</h3>
                <p class="text-muted mb-0">Your bill has been paid successfully.</p>
                <p class="bbps-txn-id mb-0" id="successTxnId">—</p>
            </div>
        </div>
    </div>
    <div id="bbpsToastContainer"></div>
</div>
@push('js')
<script>
(function(){
    var getOperatorsUrl='{{ url("bill-payment/get-operators") }}', fetchBillUrl='{{ url("bill-payment/fetch-bill") }}', payBillUrl='{{ url("bill-payment/pay") }}';
    var csrfToken=document.querySelector('#bbpsBillForm input[name="_token"]')?document.querySelector('#bbpsBillForm input[name="_token"]').value:(document.querySelector('meta[name="csrf-token"]')&&document.querySelector('meta[name="csrf-token"]').content);
    var lastBillFetch=null, lastOperatorId=null, lastOperatorName=null, lastCanumber=null, lastAmount=null;
    function showToast(msg,type){ type=type||'success'; var c=document.getElementById('bbpsToastContainer'); var t=document.createElement('div'); t.className='alert alert-'+(type==='success'?'success':'danger')+' alert-dismissible fade show'; t.innerHTML=msg+' <button type="button" class="btn-close" data-bs-dismiss="alert"></button>'; c.appendChild(t); setTimeout(function(){t.remove();},4000); }
    function setOperatorDropdown(operators){ var sel=document.getElementById('billerSelect'); sel.innerHTML='<option value="">Select biller</option>'; if(Array.isArray(operators)){ operators.forEach(function(op){ var id=op.id||op.operator_id||op.value; var name=op.name||op.operator_name||op.text||String(id); if(id){ var o=document.createElement('option'); o.value=id; o.textContent=name; o.dataset.name=name; sel.appendChild(o); } }); } else if(operators&&typeof operators==='object'){ Object.keys(operators).forEach(function(id){ var n=operators[id]; if(typeof n==='string'){ var o=document.createElement('option'); o.value=id; o.textContent=n; o.dataset.name=n; sel.appendChild(o); } }); } }
    async function loadOperators(){ var sel=document.getElementById('billerSelect'); sel.innerHTML='<option value="">Loading...</option>'; try{ var r=await fetch(getOperatorsUrl,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify({mode:'online'})}); var d=await r.json(); if(d.success&&d.data){ setOperatorDropdown(d.data); } else{ sel.innerHTML='<option value="">Failed to load billers</option>'; showToast(d.message||'Failed to load billers.','error'); } }catch(e){ sel.innerHTML='<option value="">Failed to load billers</option>'; showToast('Failed to load billers.','error'); } }
    loadOperators();
    document.getElementById('fetchBillBtn').addEventListener('click',async function(){ var consumer=document.getElementById('consumerNumber').value.trim(); var billerSel=document.getElementById('billerSelect'); var biller=billerSel.value; if(!consumer||!biller){ showToast('Please enter consumer number and select biller.','error'); return; } var btn=this; btn.disabled=true; btn.textContent='Fetching...'; try{ var r=await fetch(fetchBillUrl,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify({operator:biller,canumber:consumer,mode:'online'})}); var d=await r.json(); if(d.success&&d.data){ var data=d.data; var billFetch=data.bill_fetch||data.data||data; var userName=billFetch.userName||billFetch.user_name||billFetch.customerName||'—'; var billAmount=billFetch.billAmount||billFetch.bill_amount||billFetch.billnetamount||billFetch.amount||'0'; var dueDate=billFetch.dueDate||billFetch.due_date||'—'; lastBillFetch=billFetch; lastOperatorId=biller; lastOperatorName=billerSel.selectedOptions[0]?(billerSel.selectedOptions[0].dataset.name||billerSel.selectedOptions[0].textContent):biller; lastCanumber=consumer; lastAmount=parseFloat(String(billAmount).replace(/[^0-9.]/g,''))||0; document.getElementById('summaryName').textContent=userName; document.getElementById('summaryAmount').textContent='₹ '+String(billAmount); document.getElementById('summaryDueDate').textContent=dueDate; document.getElementById('summaryBiller').textContent=lastOperatorName; document.getElementById('billSummaryCard').classList.remove('d-none'); showToast('Bill fetched successfully.'); } else{ showToast(d.message||'Failed to fetch bill.','error'); } }catch(e){ showToast('Failed to fetch bill.','error'); } finally{ btn.disabled=false; btn.textContent='Fetch Bill'; } });
    document.getElementById('payNowBtn').addEventListener('click',async function(){ if(!lastBillFetch){ showToast('Please fetch bill first.','error'); return; } var btn=this; btn.disabled=true; btn.innerHTML='Processing...'; try{ var r=await fetch(payBillUrl,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify({operator:lastOperatorId,operator_name:lastOperatorName,canumber:lastCanumber,amount:lastAmount,mode:'online',bill_fetch:lastBillFetch})}); var d=await r.json(); if(d.success){ document.getElementById('paymentSection').classList.add('d-none'); document.getElementById('billSummaryCard').classList.add('d-none'); document.getElementById('successScreen').classList.remove('d-none'); document.getElementById('successTxnId').textContent=d.reference_id||('TXN'+Date.now()); showToast(d.message||'Payment successful!'); } else{ showToast(d.message||'Payment failed.','error'); } }catch(e){ showToast('Payment request failed.','error'); } finally{ btn.disabled=false; btn.innerHTML='Pay Now'; } });
})();
</script>
@endpush
@endsection
