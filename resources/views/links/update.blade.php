@extends('layouts.app')
@section('content')

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Введите новую ссылку!</h1>
                <form method="POST" action="{{route('links.update',$link)}}">
                    @csrf
                    @method('PUT')
                    <p>
                        <input type="text" name="link" placeholder="Введите ссылку" class="form-control mt-5">
                        <button type="submit" class="btn btn-success my-2">Сохранить</button>
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection
