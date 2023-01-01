@extends('layouts.app')
@section('content')
    <section class="section container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Details Category</h5>
                        <!-- General Form Elements -->
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Name Category:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control " name="title" required=""
                                        value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-auto ">
                                    <button type="submit" class="btn btn-primary">Create category</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ route('home') }}" class="btn btn-success">Back</a>
                                </div>
                            </div>
                        </form><!-- End General Form Elements -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
