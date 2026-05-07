<x-app-layout>
    <x-slot name="title">Edit User</x-slot>
    <x-slot name="header">Edit Pengguna: {{ $user->name }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <i class="bi bi-pencil-square text-blue-500 text-xl"></i>
                <h3 class="text-lg font-semibold text-slate-800">Form Edit User</h3>
            </div>
            
            <form action="{{ route('user.update', $user) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors @error('name') border-red-500 @enderror">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors @error('email') border-red-500 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Hak Akses (Role)</label>
                        <select name="role" id="role" required
                                class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors"
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User / Karyawan</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <p class="mt-1 text-xs text-slate-500">Anda tidak bisa mengubah hak akses akun Anda sendiri.</p>
                        @endif
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-sm font-medium text-slate-700 mb-3">Ubah Password <span class="text-xs text-slate-400 font-normal">(Opsional - Kosongkan jika tidak ingin mengubah)</span></p>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-xs font-medium text-slate-600 mb-1">Password Baru</label>
                                <input type="password" name="password" id="password" minlength="8"
                                       class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors @error('password') border-red-500 @enderror">
                                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-xs font-medium text-slate-600 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" minlength="8"
                                       class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <a href="{{ route('user.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
