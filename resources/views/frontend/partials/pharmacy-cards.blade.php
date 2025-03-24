@foreach($pharmacies as $pharmacy)
    <div class="pharmacy-card">
        <div class="pharmacy-logo">
            <img src="{{ $pharmacy->image ? asset('storage/pharmacy/' . $pharmacy->image->path) : asset('storage/pharmacy/pharma.png') }}" alt="{{ $pharmacy->name }} logo" />
        </div>
        <h3 class="pharmacy-name">{{ $pharmacy->name }}</h3>
        <div class="pharmacy-info">
            <div class="info-line">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $pharmacy->address }}</span>
            </div>
        </div>
        <div class="pharmacy-actions">
            <a href="{{ route('pharmacy.show', $pharmacy->id) }}" class="action-button details">المزيد</a>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach
