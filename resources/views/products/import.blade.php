@extends('layouts.app')

@section('title', 'Import Products - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Import Products</h1>
            <p class="text-gray-600 mt-2">Import products from Excel file to quickly add multiple products to your catalog.</p>
        </div>

        <!-- Import Form -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('products.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- File Upload -->
                <div class="mb-6">
                    <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Excel File <span class="text-red-500">*</span>
                    </label>
                    <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                    @error('excel_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">
                        Accepted formats: .xlsx, .xls (Max size: 10MB)
                    </p>
                </div>

                <!-- Instructions -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">📋 Import Instructions:</h3>
                    <ol class="list-decimal list-decimal list-inside space-y-2 text-sm text-gray-700">
                        <li>Download the sample template using the button below</li>
                        <li>Fill in your product data in the Excel file</li>
                        <li>Required columns: name, description, brand, classification, price, size_volume, quantity, skin_types, active_ingredients</li>
                        <li>Save the file and upload it here</li>
                        <li>Review the import results</li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.download-template') }}" 
                       class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">
                        📥 Download Sample Template
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-jade-green text-white rounded-md hover:bg-jade-green-700 transition font-semibold">
                        📤 Import Products
                    </button>
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition font-semibold">
                        Cancel
                    </a>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 0 8 8 0 016 0zm0-2a8 8 0 100-16 0 8 8 0 016 0zM2.857-7.714a.75.75 0 00-1.064-.06l-1.064 1.064-.06.06L10 11.071l-1.064-1.064a.75.75 0 00-1.064-.06l-1.064 1.064-.06.06zm-1.064 3.5a.75.75 0 00-1.064-.06L10 14.571l-1.064-1.064a.75.75 0 00-1.064-.06l-1.064 1.064-.06.06z"/>
                            </svg>
                            <div>
                                <h3 class="text-green-800 font-medium">Success!</h3>
                                <p class="text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 0 8 8 0 016 0zM2.857-7.714a.75.75 0 00-1.064-.06l-1.064 1.064-.06.06L10 11.071l-1.064-1.064a.75.75 0 00-1.064-.06l-1.064 1.064-.06.06zm-1.064 3.5a.75.75 0 00-1.064-.06L10 14.571l-1.064-1.064a.75.75 0 00-1.064-.06l-1.064 1.064-.06.06z"/>
                            </svg>
                            <div>
                                <h3 class="text-red-800 font-medium">Error!</h3>
                                <p class="text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Old Input Display -->
                @if(old('excel_file'))
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 016 0zm-1 1V9a8 8 0 01-16 0 8 8 0 016 0zm1-1V9a8 8 0 01-16 0 8 8 0 016 0zm1-1v10a8 8 0 01-16 0 8 8 0 016 0zm0 2a8 8 0 01-16 0 8 8 0 016 0zM3 12a8 8 0 0116 0 8 8 0 016 0zm-1 1V9a8 8 0 01-16 0 8 8 0 016 0zm1-1v10a8 8 0 01-16 0 8 8 0 016 0zM3 12a8 8 0 0116 0 8 8 0 016 0z"/>
                            </svg>
                            <div>
                                <h3 class="text-yellow-800 font-medium">Previous Upload:</h3>
                                <p class="text-yellow-700">File: {{ old('excel_file') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
