@extends('layouts.app')
@section('content')
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Генератор коротких ссылок</h1>
                <form method="POST" action="{{route('links.store')}}">
                    @csrf
                    <p>
                        <input type="text" name="link" placeholder="Введите ссылку" class="form-control mt-5">
                        <button type="submit" class="btn btn-success my-2">Сократить</button>
                    </p>
                </form>
            </div>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success">
                <p class="mt-3">{{ Session::get('success')}}</p>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Номер</th>
                    <th scope="col">Сокращенная ссылка</th>
                    <th scope="col">Исходная ссылка</th>
                    <th scope="col">Переходов</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shortlinks as $link)
                    <tr>
                        <td>{{$link->id}}</td>
                        <td>
                            <a href="{{route('links.show', $link->code) }}" target="_blank">
                                {{route('links.show', $link->code) }}
                            </a>
                        </td>
                        <td>{{$link->link}}</td>
                        <td>{{$link->count}}</td>
                        <td><a class="border-0 btn btn-primary" href="{{route('links.edit',$link)}}"><i class="bi bi-pencil-fill"></i></a></td>
                        <form action="{{route('links.destroy', $link)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="border-0 btn btn-danger"><i class="bi bi-trash3-fill"></i></button></td>
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection


