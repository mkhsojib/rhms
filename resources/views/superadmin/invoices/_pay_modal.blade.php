<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="payForm" method="POST" action="{{ route('superadmin.invoices.storePayment', $invoice) }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="payModalLabel">Pay Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if($invoice->appointment->type === 'ruqyah')
            <div class="form-group">
              <label>Session Type</label>
              <input type="text" class="form-control" value="{{ ucfirst($invoice->appointment->session_type_name) }}" readonly>
            </div>
            <div class="form-group">
              <label>Session Price</label>
              <input type="number" step="0.01" min="0" name="amount" id="ruqyah_amount" class="form-control" value="{{ $invoice->amount }}" required>
            </div>
            <div class="form-group">
              <label>Discount</label>
              <input type="number" step="0.01" min="0" name="discount" id="ruqyah_discount" class="form-control" value="0">
            </div>
            <div class="form-group">
              <label>Total</label>
              <input type="number" step="0.01" min="0" name="paid_amount" id="ruqyah_total" class="form-control" value="{{ $invoice->amount }}" readonly>
            </div>
          @elseif($invoice->appointment->type === 'hijama')
            <div class="form-group">
              <label>Head Cup Price</label>
              <input type="number" step="0.01" min="0" id="head_cup_price" class="form-control" value="{{ $invoice->amount }}">
            </div>
            <div class="form-group">
              <label>Head Cup Qty</label>
              <input type="number" min="0" id="head_cup_qty" class="form-control" value="0">
            </div>
            <div class="form-group">
              <label>Body Cup Price</label>
              <input type="number" step="0.01" min="0" id="body_cup_price" class="form-control" value="{{ $invoice->amount }}">
            </div>
            <div class="form-group">
              <label>Body Cup Qty</label>
              <input type="number" min="0" id="body_cup_qty" class="form-control" value="0">
            </div>
            <div class="form-group">
              <label>Discount</label>
              <input type="number" step="0.01" min="0" id="hijama_discount" class="form-control" value="0">
            </div>
            <div class="form-group">
              <label>Total</label>
              <input type="number" step="0.01" min="0" name="paid_amount" id="hijama_total" class="form-control" value="0" readonly>
            </div>
            <input type="hidden" name="amount" id="hijama_amount" value="0">
            <input type="hidden" name="discount" id="hijama_discount_hidden" value="0">
          @endif
          <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
              <option value="cash">Cash</option>
              <option value="card">Card</option>
              <option value="bank">Bank Transfer</option>
            </select>
          </div>
          <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Submit Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function updateRuqyahTotal() {
  var amount = parseFloat(document.getElementById('ruqyah_amount').value) || 0;
  var discount = parseFloat(document.getElementById('ruqyah_discount').value) || 0;
  document.getElementById('ruqyah_total').value = (amount - discount).toFixed(2);
}
document.getElementById('ruqyah_amount')?.addEventListener('input', updateRuqyahTotal);
document.getElementById('ruqyah_discount')?.addEventListener('input', updateRuqyahTotal);

function updateHijamaTotal() {
  var headPrice = parseFloat(document.getElementById('head_cup_price').value) || 0;
  var headQty = parseInt(document.getElementById('head_cup_qty').value) || 0;
  var bodyPrice = parseFloat(document.getElementById('body_cup_price').value) || 0;
  var bodyQty = parseInt(document.getElementById('body_cup_qty').value) || 0;
  var discount = parseFloat(document.getElementById('hijama_discount').value) || 0;
  var total = (headPrice * headQty) + (bodyPrice * bodyQty) - discount;
  document.getElementById('hijama_total').value = total.toFixed(2);
  document.getElementById('hijama_amount').value = (headPrice * headQty + bodyPrice * bodyQty).toFixed(2);
  document.getElementById('hijama_discount_hidden').value = discount.toFixed(2);
}
['head_cup_price','head_cup_qty','body_cup_price','body_cup_qty','hijama_discount'].forEach(function(id){
  document.getElementById(id)?.addEventListener('input', updateHijamaTotal);
});
</script> 