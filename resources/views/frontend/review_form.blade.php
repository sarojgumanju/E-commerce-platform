<x-frontend-layout>
<div class="py-8 lg:py-12">
    <div class="container mx-auto px-4" style="width: 86%; max-width: 1400px;">
        <div class="max-w-2xl mx-auto">

            <div class="bg-white rounded-2xl shadow-card border border-gray-100 p-8">

                <h1 class="text-3xl font-bold text-[#0b1e33] mb-4">
                    Rate Product
                </h1>

                <p class="text-[#475569] mb-6">
                    Product: <strong>{{ $product->name }}</strong>
                </p>

                <form action="{{ route('reviews.store', $product) }}" method="POST">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $orderId }}">

                    {{-- STAR RATING --}}
                    <div class="mb-6">
                        <label class="block text-[#475569] mb-3">
                            Your Rating *
                        </label>

                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                    <i class="fas fa-star text-4xl text-gray-300 rating-star"></i>
                                </label>
                            @endfor
                        </div>

                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- COMMENT --}}
                    <div class="mb-6">
                        <label class="block text-[#475569] mb-2">
                            Your Review *
                        </label>

                        <textarea
                            name="comment"
                            rows="5"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#f97316]"
                            placeholder="Share your experience..."
                            required
                        >{{ old('comment') }}</textarea>

                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Review
                        </button>

                        <a href="{{ route('order.history') }}"
                           class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
.rating-star {
    transition: 0.2s ease;
    cursor: pointer;
}

.rating-star.active {
    color: #facc15;
    transform: scale(1.1);
}
</style>

{{-- SCRIPT --}}
<script>
document.querySelectorAll('input[name="rating"]').forEach(radio => {
    radio.addEventListener('change', function () {
        let value = parseInt(this.value);

        document.querySelectorAll('.rating-star').forEach((star, index) => {
            if (index < value) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    });
});
</script>

</x-frontend-layout>