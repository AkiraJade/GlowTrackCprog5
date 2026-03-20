@extends('layouts.admin')

@section('title', 'Seller Applications - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Seller Applications</h1>
        <p class="text-gray-600 mt-2">Review and manage seller verification requests</p>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('admin.seller-applications') }}" class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ !request('status') ? 'border-jade-green text-jade-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    All Applications ({{ $applications->total() }})
                </a>
                <a href="{{ route('admin.seller-applications', ['status' => 'pending']) }}" class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'pending' ? 'border-jade-green text-jade-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pending
                </a>
                <a href="{{ route('admin.seller-applications', ['status' => 'approved']) }}" class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'approved' ? 'border-jade-green text-jade-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Approved
                </a>
                <a href="{{ route('admin.seller-applications', ['status' => 'rejected']) }}" class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'rejected' ? 'border-jade-green text-jade-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Rejected
                </a>
            </nav>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">
                    @if(request('status') === 'pending')
                        Pending Applications
                    @elseif(request('status') === 'approved')
                        Approved Applications
                    @elseif(request('status') === 'rejected')
                        Rejected Applications
                    @else
                        All Applications
                    @endif
                </h2>
                <div class="text-sm text-gray-500">
                    {{ $applications->total() }} applications
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Business</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($applications as $application)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-jade-green flex items-center justify-center">
                                            <span class="text-white font-medium">{{ strtoupper(substr($application->user->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $application->brand_name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($application->business_description, 30) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($application->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($application->status === 'approved')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $application->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.seller-applications.show', $application) }}" class="text-jade-green hover:text-jade-green-900 mr-3">View Details</a>
                                @if($application->status === 'pending')
                                    <form method="POST" action="{{ route('admin.seller-applications.approve', $application) }}" class="inline" onsubmit="return confirm('Are you sure you want to approve this seller application?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.seller-applications.reject', $application) }}" class="inline" onsubmit="return confirm('Are you sure you want to reject this seller application?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                @if(request('status'))
                                    No {{ request('status') }} applications found
                                @else
                                    No seller applications found
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($applications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection