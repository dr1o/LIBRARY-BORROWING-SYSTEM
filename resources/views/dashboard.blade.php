<x-app-layout>
    @if (Auth::user()?->role == 'admin')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Users -->
                    <div class="bg-blue-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Total Users</h3>
                        <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    </div>

                    <!-- Total Equipments -->
                    <div class="bg-green-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Total Equipments</h3>
                        <p class="text-2xl font-bold">{{ $totalEquipments }}</p>
                    </div>

                    <!-- Total Loans -->
                    <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Total Loans</h3>
                        <p class="text-2xl font-bold">{{ $totalLoans }}</p>
                    </div>

                    <!-- Pending Loans -->
                    <div class="bg-yellow-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Pending Loans</h3>
                        <p class="text-2xl font-bold">{{ $pendingLoans }}</p>
                    </div>

                    <!-- Currently Borrowed -->
                    <div class="bg-red-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Currently Borrowed</h3>
                        <p class="text-2xl font-bold">{{ $borrowedLoans }}</p>
                    </div>
                </div>
            </div>
        </div>

    @elseif(Auth::user()?->role == 'user')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Dashboard</h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Active Loans -->
                    <div class="bg-yellow-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Active Loans</h3>
                        <p class="text-2xl font-bold">{{ $activeLoans }}</p>
                    </div>

                    <!-- Returned Loans -->
                    <div class="bg-green-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Returned Loans</h3>
                        <p class="text-2xl font-bold">{{ $returnedLoans }}</p>
                    </div>

                    <!-- Available Equipments -->
                    <div class="bg-blue-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-gray-700">Available Equipments</h3>
                        <p class="text-2xl font-bold">{{ $availableEquipments }}</p>
                    </div>
                </div>
            </div>
        </div>

    @else
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    @endif
</x-app-layout>