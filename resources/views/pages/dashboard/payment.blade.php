
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Saved Payment Gateways</h2>
                        
                        <form action="{{ route('dashboard.bank-details.update') }}" method="POST" class="max-w-xl space-y-4 text-left bg-gray-50 border border-gray-100 rounded-2xl p-6">
                            @csrf
                            
                            <p class="text-xs text-gray-500 mb-4">Save your card or bank details for faster checkout and refunds. You can change these at any time.</p>

                            <div>
                                <label for="bank_name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Bank / Provider Name</label>
                                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $bankDetail->bank_name ?? '') }}" placeholder="e.g. Chase, Bank of America, PayPal"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                            </div>
                            
                            <div>
                                <label for="account_holder_name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Account / Cardholder Name</label>
                                <input type="text" name="account_holder_name" id="account_holder_name" value="{{ old('account_holder_name', $bankDetail->account_holder_name ?? '') }}" placeholder="John Doe"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                            </div>
                            
                            <div>
                                <label for="account_number" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Account / Card Number</label>
                                <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $bankDetail->account_number ?? '') }}" placeholder="**** **** **** 1234"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry_date" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $bankDetail->expiry_date ?? '') }}" placeholder="MM/YY"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                                </div>
                                <div>
                                    <label for="cvc" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">CVC / CVV</label>
                                    <input type="text" name="cvc" id="cvc" value="{{ old('cvc', $bankDetail->cvc ?? '') }}" placeholder="123"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                                </div>
                            </div>
                            
                            <button type="submit" class="mt-4 w-full py-2.5 px-4 bg-gray-900 hover:bg-gray-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-md shadow-gray-100">
                                Save Details
                            </button>
                        </form>
                    