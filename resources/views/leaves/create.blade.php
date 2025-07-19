<x-app-layout>
    @php
        $title = 'Request Leave';
    @endphp

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2><i class="fas fa-calendar-plus"></i> {{ $title }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="from_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('from_date') is-invalid @enderror"
                                    id="from_date" name="from_date" value="{{ old('from_date') }}" required>
                                @error('from_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="to_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('to_date') is-invalid @enderror"
                                    id="to_date" name="to_date" value="{{ old('to_date') }}" required>
                                @error('to_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4"
                                    required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="document" class="form-label">Supporting Document (optional)</label>
                                <input type="file" class="form-control @error('document') is-invalid @enderror"
                                    id="document" name="document">
                                @error('document')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Accepted formats: PDF, JPG, PNG (max: 2MB)</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Submit Request
                                </button>
                                <a href="{{ route('leaves.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Leave Requests
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
