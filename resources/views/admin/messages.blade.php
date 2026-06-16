@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Customer Messages</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Read and manage incoming inquiries, support messages, and consultations.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/40 text-emerald-700 dark:text-emerald-400 rounded-2xl text-sm font-medium flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-between items-center">
            <div class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Messages: <span class="text-slate-900 dark:text-white font-bold">{{ $messages->total() }}</span></div>
        </div>

        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
                        <th class="p-5 font-bold">Contact Info</th>
                        <th class="p-5 font-bold">Inquiry Type</th>
                        <th class="p-5 font-bold">Message Preview</th>
                        <th class="p-5 font-bold">Status</th>
                        <th class="p-5 font-bold">Submitted</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50 dark:divide-slate-800/60">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group {{ !$msg->is_read ? 'bg-indigo-50/20 dark:bg-indigo-950/15' : '' }}">
                            <td class="p-5">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md shadow-indigo-500/10">
                                        {{ strtoupper(substr($msg->first_name, 0, 1)) }}{{ strtoupper(substr($msg->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-900 dark:text-white text-base">{{ $msg->first_name }} {{ $msg->last_name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $msg->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider 
                                    @if($msg->inquiry_type === 'consultation') bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 border border-purple-100 dark:border-purple-900/40
                                    @elseif($msg->inquiry_type === 'support') bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40
                                    @else bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/40
                                    @endif">
                                    {{ $msg->inquiry_type }}
                                </span>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-600 dark:text-slate-300 font-medium max-w-xs truncate">{{ $msg->message }}</p>
                            </td>
                            <td class="p-5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $msg->is_read ? 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200' : 'bg-indigo-100 dark:bg-indigo-950/60 text-indigo-850 dark:text-indigo-300' }}">
                                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $msg->is_read ? 'bg-slate-400' : 'bg-indigo-550 dark:bg-indigo-400' }}"></span>
                                    {{ $msg->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-700 dark:text-slate-300 font-bold">{{ $msg->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">{{ $msg->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="p-5 text-right whitespace-nowrap space-x-1">
                                <button type="button" 
                                        onclick="openMessageModal('{{ e($msg->first_name) }} {{ e($msg->last_name) }}', '{{ e($msg->email) }}', '{{ e($msg->inquiry_type) }}', '{{ e($msg->message) }}', '{{ $msg->created_at->format('M d, Y H:i') }}')"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-100 dark:hover:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl text-xs font-bold transition-all">
                                    View Detail
                                </button>
                                
                                <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 {{ $msg->is_read ? 'bg-slate-50 dark:bg-slate-800 hover:bg-slate-150 dark:hover:bg-slate-750 text-slate-600 dark:text-slate-300' : 'bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 dark:hover:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400' }} rounded-xl text-xs font-bold transition-all">
                                        {{ $msg->is_read ? 'Mark Unread' : 'Mark Read' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-950/60 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-bold transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                No messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-50 dark:border-slate-800">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Premium Modal -->
    <div id="messageModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeMessageModal()"></div>

            <!-- Centered modal card -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100 dark:border-slate-800">
                <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl leading-6 font-extrabold text-slate-900 dark:text-white" id="modal-title-name">
                                    Message Detail
                                </h3>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 capitalize" id="modal-inquiry-type"></span>
                            </div>
                            <div class="mt-2 text-sm text-slate-500 dark:text-slate-400 font-medium" id="modal-email"></div>
                            <div class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5" id="modal-date"></div>

                            <hr class="my-4 border-slate-100 dark:border-slate-800">

                            <div class="mt-4">
                                <p class="text-sm font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Message</p>
                                <div class="bg-slate-50 dark:bg-slate-850 rounded-2xl p-4 text-slate-700 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-wrap overflow-y-auto max-h-60" id="modal-message-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50/50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 flex justify-end border-t dark:border-slate-800">
                    <button type="button" onclick="closeMessageModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm px-4 py-2 bg-white dark:bg-slate-855 text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 sm:w-auto sm:text-sm transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openMessageModal(name, email, type, message, date) {
            document.getElementById('modal-title-name').innerText = name;
            document.getElementById('modal-email').innerText = email;
            document.getElementById('modal-inquiry-type').innerText = type;
            document.getElementById('modal-message-body').innerText = message;
            document.getElementById('modal-date').innerText = 'Received on: ' + date;
            
            const modal = document.getElementById('messageModal');
            modal.classList.remove('hidden');
        }

        // Close modal when clicking outside of it
        function closeMessageModal() {
            const modal = document.getElementById('messageModal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
