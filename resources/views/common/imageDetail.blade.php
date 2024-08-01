<div id="image-detail">
    <div class="d-flex justify-content-center shadow-sm p-3 rounded">
        <img src="{{ asset($product->image_thumbnail) }}" alt="" id="large-image" class="object-fit-contain rounded" style="height: 300px; max-width: 100%; object-position: center;">
    </div>
    <div id="small-image-area" class="mt-3 border border-1 border-secondary px-2 position-relative rounded-1 w-100 shadow-sm">
        <div class="w-100 overflow-x-hidden position-relative d-flex align-items-center" style="height: 90px">
            <div id="small-image-container" class="d-flex gap-2 position-absolute" style="transition: 0.3s">
                @foreach ($product->productGalleries as $image)
                <img src="{{asset($image['image'])}}" alt="" class="object-fit-contain rounded" style="height: 70px">
                @endforeach
            </div>
        </div>
        <button class="carousel-control-prev" type="button" style="width: 5%;" id="carousel-detail-prev">
            <i class="fa-solid fa-chevron-left"></i>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" style="width: 5%;" id="carousel-detail-next">
            <i class="fa-solid fa-chevron-right"></i>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<script>
    ;(() => {
        const smallImageContainer = document.getElementById('small-image-container');
        let left = 0;
        const increase = 150;
        smallImageContainer.style.left = '0';
        // Choose Image
        smallImageContainer.querySelectorAll('img').forEach((img, index) => {
            img.onclick = function() {
                document.getElementById('large-image').src = img.src;
            }
        });
        // Prev
        document.querySelector('button#carousel-detail-prev').onclick = function() {
            left += increase;
            if (left > 0) left = 0;
            smallImageContainer.style.left = `${left}px`;
        }
        // Next
        document.querySelector('button#carousel-detail-next').onclick = function() {
            const parentWidth = smallImageContainer.parentElement.offsetWidth;
            left -= increase;
            if (smallImageContainer.offsetWidth + left < parentWidth) {
                left = parentWidth - smallImageContainer.offsetWidth;
            }
            smallImageContainer.style.left = `${left}px`;
        }
    })();
</script>