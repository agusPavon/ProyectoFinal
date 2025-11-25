<section class="reviews-summary text-center">
    <div class="review-card">
        <div class="review-header">
            <i class="fas fa-user-circle user-icon"></i>

            <button class="review-btn">
                <i class="fas fa-star"></i> Reviews del mes: {{ $reviewsCount }}
            </button>

            <button onclick="window.location.href='/mapa'" class="add-review-btn">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</section>