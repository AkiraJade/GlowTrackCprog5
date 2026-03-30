@extends('layouts.admin')

@section('title', 'Edit Product - GlowTrack Admin')

@section('content')
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <p class="page-label" style="margin-bottom:.3rem;">Product Management</p>
            <h1 class="page-title">Edit Product</h1>
            <p style="color:rgba(107,79,79,.55);font-size:.825rem;margin-top:.25rem;">
                Editing: <span style="color:#7EC8B3;font-weight:600;">{{ $product->name }}</span>
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:.625rem;">
            <a href="{{ route('admin.products') }}"
               style="display:inline-flex;align-items:center;gap:.4rem;padding:.525rem 1.1rem;
                      border-radius:.75rem;font-size:.825rem;font-weight:600;text-decoration:none;
                      color:#6B4F4F;background:rgba(255,255,255,.6);
                      border:1px solid rgba(168,213,194,.4);transition:all .2s ease;"
               onmouseover="this.style.background='rgba(255,255,255,.88)'"
               onmouseout="this.style.background='rgba(255,255,255,.6)'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Back to Products
            </a>
            <a href="{{ route('products.show', $product) }}"
               style="display:inline-flex;align-items:center;gap:.4rem;padding:.525rem 1.1rem;
                      border-radius:.75rem;font-size:.825rem;font-weight:600;text-decoration:none;
                      color:#2D6A5B;background:rgba(126,200,179,.15);
                      border:1px solid rgba(126,200,179,.32);transition:all .2s ease;"
               onmouseover="this.style.background='rgba(126,200,179,.28)'"
               onmouseout="this.style.background='rgba(126,200,179,.15)'"
               target="_blank">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                </svg>
                View Product
            </a>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="glass-card" style="border-radius:1rem;padding:1rem 1.25rem;
                    background:rgba(246,193,204,.2);border-color:rgba(220,150,170,.35);">
            <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:.5rem;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#8B3A4A;flex-shrink:0;">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p style="font-size:.825rem;font-weight:600;color:#8B3A4A;">Please fix the following errors:</p>
            </div>
            <ul style="list-style:disc;padding-left:1.5rem;display:flex;flex-direction:column;gap:.25rem;">
                @foreach ($errors->all() as $error)
                    <li style="font-size:.8rem;color:#8B3A4A;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:minmax(0,2fr) minmax(0,1fr);gap:1.25rem;" class="admin-grid-2col">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Basic Information --}}
                <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                    <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);
                                display:flex;align-items:center;gap:.625rem;">
                        <div style="width:30px;height:30px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(126,200,179,.15);border:1px solid rgba(126,200,179,.28);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:#6B4F4F;">Basic Information</h2>
                    </div>
                    <div style="padding:1.5rem;display:flex;flex-direction:column;gap:1.1rem;">

                        {{-- Product Name --}}
                        <div>
                            <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                Product Name <span style="color:#D98BA0;">*</span>
                            </label>
                            <input type="text" name="name" required
                                   value="{{ old('name', $product->name) }}"
                                   class="glass-input" style="width:100%;"
                                   placeholder="e.g., Hydrating Face Serum">
                            @error('name')
                                <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Brand + Classification --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            <div>
                                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                    Brand <span style="color:#D98BA0;">*</span>
                                </label>
                                <input type="text" name="brand" required
                                       value="{{ old('brand', $product->brand) }}"
                                       class="glass-input" style="width:100%;"
                                       placeholder="e.g., CeraVe">
                                @error('brand')
                                    <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                    Product Type <span style="color:#D98BA0;">*</span>
                                </label>
                                <select name="classification" required class="glass-select" style="width:100%;">
                                    <option value="">Select type…</option>
                                    @foreach($classifications as $c)
                                        <option value="{{ $c }}" {{ old('classification', $product->classification) == $c ? 'selected' : '' }}>
                                            {{ $c }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classification')
                                    <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Price + Size + Quantity --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                            <div>
                                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                    Price (₱) <span style="color:#D98BA0;">*</span>
                                </label>
                                <input type="number" name="price" required step="0.01" min="0"
                                       value="{{ old('price', $product->price) }}"
                                       class="glass-input" style="width:100%;"
                                       placeholder="0.00">
                                @error('price')
                                    <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                    Size / Volume <span style="color:#D98BA0;">*</span>
                                </label>
                                <input type="text" name="size_volume" required
                                       value="{{ old('size_volume', $product->size_volume) }}"
                                       class="glass-input" style="width:100%;"
                                       placeholder="e.g., 30ml">
                                @error('size_volume')
                                    <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                    Quantity <span style="color:#D98BA0;">*</span>
                                </label>
                                <input type="number" name="quantity" required min="0"
                                       value="{{ old('quantity', $product->quantity) }}"
                                       class="glass-input" style="width:100%;"
                                       placeholder="0">
                                @error('quantity')
                                    <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                    <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);
                                display:flex;align-items:center;gap:.625rem;">
                        <div style="width:30px;height:30px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(168,213,194,.18);border:1px solid rgba(168,213,194,.3);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#5DAE99;">
                                <path d="M4 6h16M4 10h16M4 14h10"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:#6B4F4F;">Description</h2>
                    </div>
                    <div style="padding:1.5rem;">
                        <textarea name="description" rows="5" required
                                  class="glass-input" style="width:100%;resize:vertical;"
                                  placeholder="Describe the product, its benefits, and usage instructions…">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Skin Types --}}
                <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                    <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);
                                display:flex;align-items:center;gap:.625rem;">
                        <div style="width:30px;height:30px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(246,193,204,.18);border:1px solid rgba(246,193,204,.3);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D98BA0;">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:#6B4F4F;">Suitable Skin Types</h2>
                    </div>
                    <div style="padding:1.5rem;">
                        @php
                            $currentSkinTypes = old('skin_types', $product->skin_types ?? []);
                        @endphp
                        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:.75rem;">
                            @foreach(['Oily','Dry','Combination','Sensitive','Normal'] as $skinType)
                                <label style="display:flex;flex-direction:column;align-items:center;gap:.5rem;
                                              padding:.875rem .5rem;border-radius:.875rem;cursor:pointer;
                                              border:1px solid rgba(205,237,227,.5);transition:all .2s ease;
                                              background:rgba(255,255,255,.4);"
                                       onmouseover="this.style.background='rgba(126,200,179,.12)';this.style.borderColor='rgba(126,200,179,.35)'"
                                       onmouseout="if(!this.querySelector('input').checked){this.style.background='rgba(255,255,255,.4)';this.style.borderColor='rgba(205,237,227,.5)'}">
                                    <input type="checkbox" name="skin_types[]" value="{{ $skinType }}"
                                           style="width:16px;height:16px;accent-color:#7EC8B3;"
                                           {{ in_array($skinType, old('skin_types', $currentSkinTypes)) ? 'checked' : '' }}
                                           onchange="updateSkinTypeCard(this)">
                                    <span style="font-size:.75rem;font-weight:600;color:#6B4F4F;text-align:center;">{{ $skinType }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('skin_types')
                            <p style="font-size:.75rem;color:#8B3A4A;margin-top:.5rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Active Ingredients --}}
                <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                    <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);
                                display:flex;align-items:center;gap:.625rem;">
                        <div style="width:30px;height:30px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(255,214,165,.2);border:1px solid rgba(255,180,100,.28);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                                <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:#6B4F4F;">Active Ingredients</h2>
                    </div>
                    <div style="padding:1.5rem;">
                        @php
                            $ingredients = old('active_ingredients', $product->active_ingredients ?? []);
                            if (empty($ingredients)) $ingredients = ['Vitamin C'];
                        @endphp

                        <div id="ingredients-container" style="display:flex;flex-direction:column;gap:.625rem;">
                            @foreach($ingredients as $ingredient)
                                <div class="ingredient-row" style="display:flex;align-items:center;gap:.625rem;">
                                    <input type="text" name="active_ingredients[]"
                                           value="{{ $ingredient }}"
                                           class="glass-input" style="flex:1;"
                                           placeholder="e.g., Hyaluronic Acid">
                                    <button type="button" onclick="removeIngredient(this)"
                                            style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                                   flex-shrink:0;cursor:pointer;font-size:1rem;font-weight:700;
                                                   color:#8B3A4A;background:rgba(246,193,204,.2);
                                                   border:1px solid rgba(220,150,170,.3);transition:all .2s ease;
                                                   font-family:'Poppins',sans-serif;"
                                            onmouseover="this.style.background='rgba(246,193,204,.4)'"
                                            onmouseout="this.style.background='rgba(246,193,204,.2)'">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addIngredient()"
                                style="margin-top:.875rem;display:inline-flex;align-items:center;gap:.4rem;
                                       padding:.45rem .9rem;border-radius:.75rem;font-size:.8rem;font-weight:600;cursor:pointer;
                                       color:#2D6A5B;background:rgba(126,200,179,.12);
                                       border:1px solid rgba(126,200,179,.3);transition:all .2s ease;
                                       font-family:'Poppins',sans-serif;"
                                onmouseover="this.style.background='rgba(126,200,179,.25)'"
                                onmouseout="this.style.background='rgba(126,200,179,.12)'">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Ingredient
                        </button>

                        @error('active_ingredients')
                            <p style="font-size:.75rem;color:#8B3A4A;margin-top:.5rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>{{-- /LEFT COLUMN --}}

            {{-- RIGHT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Status (admin only) --}}
                <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                    <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);
                                display:flex;align-items:center;gap:.625rem;">
                        <div style="width:30px;height:30px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(255,214,165,.2);border:1px solid rgba(255,180,100,.28);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:#6B4F4F;">
                            Admin Status
                        </h2>
                    </div>
                    <div style="padding:1.5rem;display:flex;flex-direction:column;gap:1rem;">
                        <div>
                            <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                Approval Status
                            </label>
                            <select name="status" class="glass-select" style="width:100%;">
                                <option value="pending"  {{ old('status', $product->status) === 'pending'  ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $product->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $product->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div style="padding:.875rem;border-radius:.875rem;
                                    background:rgba(126,200,179,.08);border:1px solid rgba(126,200,179,.2);">
                            <p style="font-size:.75rem;color:rgba(107,79,79,.6);line-height:1.5;">
                                <strong style="color:#6B4F4F;">Note:</strong> As admin, changing status here will
                                take effect immediately without going through the review queue.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Product Images --}}
                <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                    <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);
                                display:flex;align-items:center;gap:.625rem;">
                        <div style="width:30px;height:30px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(168,213,194,.18);border:1px solid rgba(168,213,194,.3);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#5DAE99;">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:#6B4F4F;">Product Images</h2>
                    </div>
                    <div style="padding:1.5rem;display:flex;flex-direction:column;gap:1.1rem;">

                        {{-- Existing Images --}}
                        @if($product->images->count() > 0)
                            <div>
                                <p style="font-size:.78rem;font-weight:600;color:#6B4F4F;margin-bottom:.625rem;">Current Images</p>
                                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.625rem;">
                                    @foreach($product->images as $image)
                                        <div style="position:relative;border-radius:.75rem;overflow:hidden;
                                                    border:2px solid {{ $image->is_primary ? '#7EC8B3' : 'rgba(205,237,227,.5)' }};">
                                            <img src="{{ $image->image_url }}"
                                                 alt="Product Image"
                                                 style="width:100%;height:80px;object-fit:cover;">
                                            @if($image->is_primary)
                                                <span style="position:absolute;top:4px;left:4px;
                                                             background:#7EC8B3;color:#fff;
                                                             font-size:.6rem;font-weight:700;
                                                             padding:.15rem .4rem;border-radius:.375rem;">
                                                    Primary
                                                </span>
                                            @endif
                                            <div style="position:absolute;top:4px;right:4px;display:flex;gap:3px;">
                                                <button type="button" onclick="setPrimaryImage({{ $image->id }})"
                                                        title="Set as primary"
                                                        {{ $image->is_primary ? 'disabled' : '' }}
                                                        style="width:20px;height:20px;border-radius:50%;
                                                               background:rgba(126,200,179,.9);color:#fff;
                                                               font-size:.7rem;border:none;cursor:pointer;
                                                               display:flex;align-items:center;justify-content:center;
                                                               {{ $image->is_primary ? 'opacity:.4;cursor:not-allowed;' : '' }}">
                                                    ★
                                                </button>
                                                <button type="button" onclick="removeImage({{ $image->id }})"
                                                        title="Remove"
                                                        style="width:20px;height:20px;border-radius:50%;
                                                               background:rgba(246,100,100,.85);color:#fff;
                                                               font-size:.8rem;border:none;cursor:pointer;
                                                               display:flex;align-items:center;justify-content:center;">
                                                    ×
                                                </button>
                                            </div>
                                            <input type="hidden" name="remove_images[]" value="{{ $image->id }}"
                                                   id="remove_{{ $image->id }}" disabled>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Upload New --}}
                        <div>
                            <p style="font-size:.78rem;font-weight:600;color:#6B4F4F;margin-bottom:.625rem;">Add New Images</p>
                            <label for="images"
                                   style="display:flex;flex-direction:column;align-items:center;justify-content:center;
                                          gap:.5rem;padding:1.5rem;border-radius:.875rem;cursor:pointer;
                                          border:2px dashed rgba(126,200,179,.4);transition:all .2s ease;
                                          background:rgba(241,250,247,.4);"
                                   onmouseover="this.style.borderColor='rgba(126,200,179,.7)';this.style.background='rgba(126,200,179,.08)'"
                                   onmouseout="this.style.borderColor='rgba(126,200,179,.4)';this.style.background='rgba(241,250,247,.4)'">
                                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color:rgba(126,200,179,.7);">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span style="font-size:.78rem;color:rgba(107,79,79,.6);text-align:center;line-height:1.4;">
                                    Click to upload<br>
                                    <span style="font-size:.7rem;">PNG, JPG up to 2MB each (max 5 total)</span>
                                </span>
                                <input type="file" id="images" name="images[]"
                                       accept="image/*" multiple class="hidden"
                                       onchange="previewImages(this)">
                            </label>
                            <div id="imagePreview" style="display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;margin-top:.625rem;"></div>
                            @error('images')
                                <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Single Image Legacy --}}
                        <div style="padding-top:.875rem;border-top:1px solid rgba(205,237,227,.4);">
                            <label style="display:block;font-size:.78rem;font-weight:600;color:#6B4F4F;margin-bottom:.4rem;">
                                Single Image Upload
                                <span style="font-weight:400;color:rgba(107,79,79,.45);">(optional)</span>
                            </label>
                            <input type="file" name="photo" accept="image/*"
                                   class="glass-input" style="width:100%;padding:.4rem .7rem;cursor:pointer;">
                            @error('photo')
                                <p style="font-size:.75rem;color:#8B3A4A;margin-top:.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="primary_image" id="primary_image"
                               value="{{ $product->images->where('is_primary', true)->first()->id ?? 0 }}">
                    </div>
                </div>

                {{-- Submit --}}
                <div class="glass-card" style="border-radius:1.125rem;padding:1.25rem 1.5rem;
                            display:flex;flex-direction:column;gap:.625rem;">
                    <button type="submit" class="btn-primary" style="justify-content:center;padding:.75rem 1rem;font-size:.875rem;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn-secondary" style="justify-content:center;text-align:center;padding:.75rem 1rem;font-size:.875rem;">
                        Cancel
                    </a>
                </div>

            </div>{{-- /RIGHT COLUMN --}}

        </div>
    </form>

</div>

@push('scripts')
<script>
    /* ── Skin type card highlight ─────────────── */
    function updateSkinTypeCard(checkbox) {
        const card = checkbox.closest('label');
        if (checkbox.checked) {
            card.style.background     = 'rgba(126,200,179,.18)';
            card.style.borderColor    = 'rgba(126,200,179,.5)';
        } else {
            card.style.background     = 'rgba(255,255,255,.4)';
            card.style.borderColor    = 'rgba(205,237,227,.5)';
        }
    }

    // Initialise checked state on load
    document.querySelectorAll('input[name="skin_types[]"]').forEach(cb => {
        if (cb.checked) updateSkinTypeCard(cb);
    });

    /* ── Ingredients ──────────────────────────── */
    function addIngredient() {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.className = 'ingredient-row';
        row.style.cssText = 'display:flex;align-items:center;gap:.625rem;';
        row.innerHTML = `
            <input type="text" name="active_ingredients[]"
                   class="glass-input" style="flex:1;"
                   placeholder="e.g., Hyaluronic Acid">
            <button type="button" onclick="removeIngredient(this)"
                    style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                           flex-shrink:0;cursor:pointer;font-size:1rem;font-weight:700;
                           color:#8B3A4A;background:rgba(246,193,204,.2);
                           border:1px solid rgba(220,150,170,.3);transition:all .2s ease;font-family:'Poppins',sans-serif;"
                    onmouseover="this.style.background='rgba(246,193,204,.4)'"
                    onmouseout="this.style.background='rgba(246,193,204,.2)'">×</button>`;
        container.appendChild(row);
    }

    function removeIngredient(btn) {
        const container = document.getElementById('ingredients-container');
        if (container.children.length > 1) btn.parentElement.remove();
    }

    /* ── Image preview ────────────────────────── */
    function previewImages(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        if (!input.files) return;
        Array.from(input.files).forEach((file, idx) => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const wrap = document.createElement('div');
                wrap.style.cssText = 'position:relative;border-radius:.625rem;overflow:hidden;border:1px solid rgba(205,237,227,.5);';
                wrap.innerHTML = `<img src="${e.target.result}" style="width:100%;height:70px;object-fit:cover;">`;
                preview.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }

    /* ── Existing image management ────────────── */
    function removeImage(imageId) {
        if (!confirm('Remove this image?')) return;
        const input = document.getElementById('remove_' + imageId);
        input.disabled = false;
        input.closest('div').style.opacity = '.35';
    }

    function setPrimaryImage(imageId) {
        document.getElementById('primary_image').value = imageId;
        document.querySelectorAll('[id^="remove_"]').forEach(inp => {
            const wrap = inp.closest('div');
            if (wrap) wrap.style.borderColor = 'rgba(205,237,227,.5)';
        });
        const selectedWrap = document.getElementById('remove_' + imageId)?.closest('div');
        if (selectedWrap) selectedWrap.style.borderColor = '#7EC8B3';
    }
</script>
@endpush
@endsection
