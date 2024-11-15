@extends('public.layouts.master')
@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                        <li class="breadcrumb-item">{{ $product->title }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-7 pt-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-md-5">
                        <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner bg-light">
                                @if (count($product->images) > 0)
                                    @foreach ($product->images as $index => $img)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <img class="h-100 w-100"
                                                src="{{ asset('storage/images/product/' . $img->filename) }}"
                                                alt="Image">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                                <i class="fa fa-2x fa-angle-left text-dark"></i>
                            </a>
                            <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                                <i class="fa fa-2x fa-angle-right text-dark"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="bg-light right">
                            <h1>{{ $product->name }}</h1>
                            <div class="d-flex mb-3">
                                <div class="star-rating product mt-2" >
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>

                                        <div class="front-stars" style="width: {{$product->avgRatingPercentage}}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <small class="pt-2 ms-1">({{$product->product_ratings_count}} Reviews)</small>
                            </div>
                            @if ($product->compare_price)
                                <h2 class="price text-secondary"><del>${{ $product->compare_price }}</del></h2>
                            @endif

                            <h2 class="price ">${{ $product->price }}</h2>

                            <p>{!! Str::limit($product->description, 200) !!}</p>
                            <a href="cart.php" class="btn btn-dark add-to-cart-btn" data-id="{{ $product->id }}"><i
                                    class="fas fa-shopping-cart"></i> &nbsp;ADD TO
                                CART</a>
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="bg-light">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab"
                                        aria-controls="description" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                        data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping"
                                        aria-selected="false">Shipping & Returns</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                        type="button" role="tab" aria-controls="reviews"
                                        aria-selected="false">Reviews</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    {!! $product->description !!}
                                </div>
                                <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                    {!! $product->shipping_returns !!}
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div class="col-md-8">
                                        <form id="ratingForm" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="row">
                                                <h3 class="h4 pb-3">Write a Review</h3>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="name" placeholder="Name" value="{{ old('name') }}">
                                                    <span class="text-danger error-message" id="name-error"></span>

                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" name="email"
                                                        id="email" placeholder="Email" value="{{ old('email') }}">
                                                    <span class="text-danger error-message" id="email-error"></span>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="rating">Rating</label>
                                                    <br>
                                                    <div class="rating" style="width: 10rem">
                                                        <input id="rating-5" type="radio" name="rating"
                                                            value="5" /><label for="rating-5"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-4" type="radio" name="rating"
                                                            value="4" /><label for="rating-4"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-3" type="radio" name="rating"
                                                            value="3" /><label for="rating-3"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-2" type="radio" name="rating"
                                                            value="2" /><label for="rating-2"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-1" type="radio" name="rating"
                                                            value="1" /><label for="rating-1"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                    </div>
                                                    <span class="text-danger error-message" id="rating-error"></span>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">How was your overall experience?</label>
                                                    <textarea name="review" id="review" class="form-control" cols="30" rows="10"
                                                        placeholder="How was your overall experience?">{{ old('review') }}</textarea>
                                                    <span class="text-danger error-message" id="review-error"></span>
                                                </div>
                                                <div>
                                                    <button class="btn btn-dark" type="submit">Submit</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <div class="overall-rating mb-3">
                                            <div class="d-flex">
                                                <h1 class="h3 pe-3">{{$product->avgRating}}</h1>
                                                <div class="star-rating mt-2" >
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{$product->avgRatingPercentage}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-2 ps-2">({{$product->product_ratings_count}} Reviews)</div>
                                            </div>

                                        </div>
                                        @if (count($product->product_ratings) > 0)
                                            @foreach ($product->product_ratings as $rating)
                                            
                                            @php
                                                $ratingPercentage=($rating->rating*100)/5;
                                            @endphp
                                                <div class="rating-group mb-4">
                                                    <span> <strong>{{$rating->username}}</strong></span>
                                                    <div class="star-rating mt-2" >
                                                        <div class="back-stars">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>

                                                            <div class="front-stars" style="width:{{$ratingPercentage}}%">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-3">
                                                        <p>{{$rating->comment}}

                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                        <p>No reviews to display..</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-5 section-8">
            <div class="container">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
                <div class="col-md-12">
                    <div id="related-products" class="carousel">
                        @if (count($relatedProducts) > 0)
                            @foreach ($relatedProducts as $pro)
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('frontend.product', $pro->slug) }}" class="product-img"><img
                                                class="card-img-top"
                                                src="{{ asset('storage/images/products/' . $pro->image) }}"
                                                alt=""></a>
                                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                        <div class="product-action">
                                            <button class="btn btn-dark add-to-cart-btn" data-id="{{ $pro->id }}">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="">{{ $pro->title }}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>${{ $pro->price }}</strong></span>
                                            @if ($pro->compare_price)
                                                <span
                                                    class="h6 text-underline"><del>${{ $pro->compare_price }}</del></span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No related product to display..</p>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script>
        document.getElementById('ratingForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(el => el.innerHTML = '');

            try {
                const response = await fetch("{{ route('frontend.submit_rating') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    form.reset(); // Reset the form on success
                    toastify().success(`${data.message}`);
                } else if (data.errors) {
                    // Display errors below each input field
                    for (let field in data.errors) {
                        let errorField = document.getElementById(`${field}-error`);
                        if (errorField) {
                            errorField.innerHTML = data.errors[field].join('<br>');
                        }
                    }
                } else {
                    toastify().error(`${data.message}`);
                }
            } catch (error) {
                toastify().error('An error occurred. Please try again later.');

            }
        });
    </script>
@endsection
