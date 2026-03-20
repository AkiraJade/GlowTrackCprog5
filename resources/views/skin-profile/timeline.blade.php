@extends('layouts.app')

@section('title', 'Skin Progress Timeline - GlowTrack')

@section('content')
<!-- Timeline Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair">My Skin Journey Timeline</h1>
                    <a href="{{ route('skin-profile.index') }}" 
                       class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        ← Back to Profile
                    </a>
                </div>
                
                <!-- Add New Entry Button -->
                <div class="text-center mb-6">
                    <button onclick="openJournalModal()" 
                            class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                        📝 Add New Entry
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Timeline Entries -->
        @if($journals->count() > 0)
            <div class="space-y-6">
                @foreach($journals as $journal)
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4"
                         style="border-left-color: {{ $journal->getConditionScoreColor() }};">
                        
                        <!-- Entry Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="text-2xl">
                                    {{ $journal->condition_score >= 4 ? '😊' : 
                                      ($journal->condition_score >= 3 ? '😐' : 
                                      ($journal->condition_score >= 2 ? '😟' : '😢')) }}
                                </div>
                                <div>
                                    <span class="text-lg font-bold text-soft-brown">{{ $journal->entry_date->format('M d, Y') }}</span>
                                    <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium"
                                          style="background-color: {{ $journal->getConditionScoreColor() }}; color: white;">
                                        {{ $journal->getConditionScoreLabel() }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($journal->photo_path)
                                <img src="{{ asset('storage/journal_photos/' . $journal->photo_path) }}" 
                                     alt="Skin progress photo" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-gray-200">
                            @endif
                        </div>
                        
                        <!-- Observations -->
                        @if($journal->observations)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-lg font-semibold text-soft-brown mb-2">Observations</h4>
                                <p class="text-gray-700 leading-relaxed">{{ $journal->observations }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $journals->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                <div class="text-6xl mb-4">📖</div>
                <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-4">No Journal Entries Yet</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Start tracking your skin journey by adding daily entries about your skin condition, observations, and progress photos.
                </p>
                <button onclick="openJournalModal()" 
                        class="px-8 py-4 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-bold text-lg shadow-xl">
                    📝 Add Your First Entry
                </button>
            </div>
        @endif
    </div>
</section>

<!-- Journal Entry Modal -->
<div id="journalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-2xl w-full mx-4">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-soft-brown font-playfair">Add Journal Entry</h3>
            <button onclick="closeJournalModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form method="POST" action="{{ route('skin-journal.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" name="entry_date" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Condition Score (1-5)</label>
                <div class="flex items-center space-x-4">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="flex items-center">
                            <input type="radio" name="condition_score" value="{{ $i }}" class="sr-only peer">
                            <div class="w-12 h-12 rounded-full border-2 border-gray-300 peer-checked:border-jade-green peer-checked:bg-jade-green transition-all cursor-pointer flex items-center justify-center">
                                <span class="text-xs font-bold">{{ $i }}</span>
                            </div>
                        </label>
                    @endfor
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Observations</label>
                <textarea name="observations" rows="4" 
                          placeholder="Describe your skin condition today..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent resize-none"></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo (Optional)</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
            </div>
            
            <div class="flex justify-end space-x-4">
                <button type="submit" 
                        class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold">
                    Save Entry
                </button>
                <button type="button" onclick="closeJournalModal()" 
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition font-semibold">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openJournalModal() {
    document.getElementById('journalModal').classList.remove('hidden');
}

function closeJournalModal() {
    document.getElementById('journalModal').classList.add('hidden');
}
</script>

<style>
input[type="radio"]:checked + div {
    background-color: #7EC8B3;
    border-color: #7EC8B3;
}

input[type="radio"]:checked + div span {
    color: white;
}
</style>
@endsection
