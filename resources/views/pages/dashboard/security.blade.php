
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Account Security</h2>
                        
                        <form action="{{ route('dashboard.change-password') }}" method="POST" class="max-w-md space-y-4 text-left bg-gray-50 border border-gray-100 rounded-2xl p-6">
                            @csrf
                            
                            <div>
                                <label for="current_password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required placeholder="••••••••"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                                @error('current_password')
                                    <p class="text-[10px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">New Password</label>
                                <input type="password" name="password" id="password" required placeholder="••••••••"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                                @error('password')
                                    <p class="text-[10px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none bg-white transition-colors">
                            </div>
                            
                            <button type="submit" class="w-full py-2.5 px-4 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-md shadow-amber-100">
                                Update Password
                            </button>
                        </form>
                    