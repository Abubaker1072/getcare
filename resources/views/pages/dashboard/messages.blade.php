
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Concierge Support</h2>
                        
                        @php
                            $nameParts = explode(' ', auth()->user()->name, 2);
                            $firstName = $nameParts[0] ?? '';
                            $lastName = $nameParts[1] ?? '';
                        @endphp
                        
                        {{-- New inquiry form --}}
                        <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 border border-gray-100 rounded-2xl p-6 mb-8 text-left" id="concierge-form">
                            @csrf
                            <input type="hidden" name="first_name" value="{{ $firstName }}">
                            <input type="hidden" name="last_name" value="{{ $lastName }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            
                            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Submit a New Inquiry / Ticket</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="md:col-span-2">
                                    <label for="inquiry_type" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Inquiry Type</label>
                                    <select name="inquiry_type" id="inquiry_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors" onchange="toggleFormFields()">
                                        <option value="general">General Message</option>
                                        <option value="complain">File a Complain</option>
                                        <option value="refund">Request a Refund</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="phone_number" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" required placeholder="+1 234 567 8900" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">House Address</label>
                                    <input type="text" name="address" id="address" required placeholder="123 Main St, City" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                </div>

                                <div id="field_order_number" class="hidden">
                                    <label for="order_number" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Order Number / ID</label>
                                    <input type="text" name="order_number" id="order_number" placeholder="ORD-XYZ123" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                </div>

                                <div id="field_reason" class="hidden md:col-span-2">
                                    <label for="reason" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Reason for Refund</label>
                                    <input type="text" name="reason" id="reason" placeholder="Brief reason for your request" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                </div>

                                <div id="field_image" class="hidden md:col-span-2">
                                    <label for="image" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Product Image (Optional)</label>
                                    <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                                </div>

                                <div class="md:col-span-2" id="field_message">
                                    <label for="message" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Your Message</label>
                                    <textarea name="message" id="message" rows="4" placeholder="Describe your issue or question here..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors"></textarea>
                                </div>
                            </div>
                            
                            <button type="submit" class="mt-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-md shadow-gray-100">
                                Send Message
                            </button>
                        </form>

                        {{-- Past inquiries --}}
                        <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider border-b pb-2">Your Message Trail</h3>
                        
                        @if($messages->isEmpty())
                            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <h3 class="text-base font-bold text-gray-800">No Inquiries Found</h3>
                                <p class="text-sm text-gray-500 mt-1">If you have any questions, use the form above to reach out to our team.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($messages as $msg)
                                    <div class="border border-gray-200 rounded-2xl p-5 hover:shadow-sm transition bg-white">
                                        <div class="flex items-center justify-between gap-3 flex-wrap mb-3 border-b pb-3">
                                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase border tracking-wider 
                                                @if($msg->inquiry_type === 'consultation') bg-blue-50 text-blue-700 border-blue-100
                                                @elseif($msg->inquiry_type === 'payment') bg-rose-50 text-rose-700 border-rose-100
                                                @elseif($msg->inquiry_type === 'order_status') bg-amber-50 text-amber-700 border-amber-100
                                                @else bg-gray-50 text-gray-700 border-gray-200
                                                @endif">
                                                {{ ucwords(str_replace('_', ' ', $msg->inquiry_type)) }}
                                            </span>
                                            <span class="text-xs text-gray-400 font-medium">
                                                {{ $msg->created_at->format('M d, Y h:i A') }}
                                            </span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            @if($msg->order_number)
                                                <p class="text-xs text-gray-600 mb-1"><strong class="text-gray-900">Order ID:</strong> {{ $msg->order_number }}</p>
                                            @endif
                                            @if($msg->reason)
                                                <p class="text-xs text-gray-600 mb-1"><strong class="text-gray-900">Reason:</strong> {{ $msg->reason }}</p>
                                            @endif
                                            @if($msg->address)
                                                <p class="text-xs text-gray-600 mb-1"><strong class="text-gray-900">Address:</strong> {{ $msg->address }}</p>
                                            @endif
                                            @if($msg->phone_number)
                                                <p class="text-xs text-gray-600 mb-1"><strong class="text-gray-900">Phone:</strong> {{ $msg->phone_number }}</p>
                                            @endif
                                            @if($msg->message)
                                            <p class="text-xs text-gray-700 leading-relaxed font-medium mt-2">
                                                <strong class="text-gray-900 block mb-1">Message:</strong>
                                                {{ $msg->message }}
                                            </p>
                                            @endif
                                            @if($msg->image_path)
                                                <div class="mt-3">
                                                    <a href="{{ asset('storage/' . $msg->image_path) }}" target="_blank" class="text-xs text-amber-600 hover:text-amber-700 font-bold flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                        View Attached Image
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($msg->reply)
                                            <div class="mt-4 bg-amber-50/60 border border-amber-100/80 rounded-xl p-4 ml-2 sm:ml-6">
                                                <div class="flex items-center gap-1.5 text-amber-700 font-bold text-[10px] uppercase tracking-wider mb-2">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                    GetCare Concierge Support
                                                    @if($msg->replied_at)
                                                        <span class="text-[9px] text-gray-400 font-medium font-sans normal-case ml-auto">{{ $msg->replied_at->format('M d, Y h:i A') }}</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-800 leading-relaxed font-sans">{!! nl2br(e($msg->reply)) !!}</p>
                                            </div>
                                        @else
                                            <div class="mt-3 flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-ping"></span>
                                                Awaiting Response
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    