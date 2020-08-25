@extends('layouts.app')

@section('content')
<h1>{{ $display['heading'] }}</h1>
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home mr-1"></i>Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.list') }}">{{ 'Students' }}</a></li>
    <li class="breadcrumb-item active">{{ $display['heading'] }}</li>
</ul>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                @if(isset($dataedit))
                    {{ Form::model($dataedit, array('name'=>'formstudent','id'=>'formstudent','files'=>true, 'method' => 'POST','class'=>'form-horizontal','url' => 'admin/students/doEdit' ) ) }}
                    @php $disable = "disabled" @endphp
                    {{ Form::hidden('student_id', old('student_id',  isset($dataedit->student_id) ? $dataedit->student_id : null), array('id' => 'student_id')) }}
                @else
                    {{ Form::open(array('name'=>'formstudent', 'id'=>'formstudent', 
                                    'class' => 'form-horizontal',
                                    'files'=>true,
                                    'url' => 'admin/students/doAdd', 
                                    'method' => 'POST')) }}
                    @php $disable = "" @endphp
                @endif

                    @csrf

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                        <span class="text-danger">*</span>
                        <div class="col-md-6">
                            <input id="student_name" type="text" class="form-control col-md-8 @error('student_name') is-invalid @enderror" name="student_name" value="{{ old('student_name',  isset($dataedit->student_name) ? $dataedit->student_name : null) }}" required autocomplete="student_name" autofocus>

                            @error('student_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Roll No') }}</label>
                        <span class="text-danger">*</span>
                        <div class="col-md-6">
                            <input id="roll_no" type="text" class="form-control col-md-5 @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no',  isset($dataedit->roll_no) ? $dataedit->roll_no : null) }}" required autocomplete="roll_no" maxlength="12" autofocus>

                            @error('roll_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="class_id" class="col-md-4 col-form-label text-md-right">{{ __('Class') }}</label>
                        <span class="text-danger">*</span>
                        <div class="col-md-6">
                            {{ Form::select('class_id', $classlist, old('class_id',  isset($dataedit->class_id) ? $dataedit->class_id : null),
                             array('id' => 'class_id', $disable, 'class' => 'input-sm col-md-6 form-control')) }}

                            @error('class_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="student_email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                        <div class="col-md-6">
                            <input id="student_email" type="email" class="form-control col-md-10 @error('student_email') is-invalid @enderror" name="student_email" value="{{ old('student_email',  isset($dataedit->student_email) ? $dataedit->student_email : null) }}" required autocomplete="student_email" autofocus>

                            @error('student_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="default" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                        <div class="col-md-6 mt-2">
                            {{ Form::radio('gender', '0', old('gender',  isset($dataedit->gender) ? $dataedit->gender : null) , array('id' =>'gender','name' => 'gender')) }}
                            &nbsp{{ trans('Male') }}&nbsp
                            {{ Form::radio('gender', '1', old('gender',  isset($dataedit->gender) ? $dataedit->gender : null) , array('id' =>'gender','name' => 'gender')) }}
                            &nbsp{{ trans('Female') }}&nbsp
                            {{ Form::radio('gender', '9', old('gender',  isset($dataedit->gender) ? $dataedit->gender : null) , array('id' =>'gender','name' => 'gender')) }}
                            &nbsp{{ trans('Other') }}&nbsp

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('title', 'DOB', array('for'=>'dob', 'class' => 'col-md-4 col-form-label text-md-right') ) !!}
                        <div class="col-md-6">
                            {{ Form::date('dob', old('dob',  isset($dataedit->dob) ? $dataedit->dob : null), array('id' => 'dob','class' => 'form-control col-md-6')) }}

                            @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if(isset($dataedit))
                    <div class="form-group row">
                        {!! Form::label('title', 'Status', array('for'=>'status', 'class' => 'col-md-4 col-form-label text-md-right') ) !!}
                        <div class="col-md-6 mt-2">
                            {{ Form::radio('valid_flg', '0', old('valid_flg',  isset($dataedit->valid_flg) ? $dataedit->valid_flg : null) , array('id' =>'valid_flg','name' => 'valid_flg')) }}
                            &nbsp{{ trans('Active') }}&nbsp
                            {{ Form::radio('valid_flg', '1', old('valid_flg',  isset($dataedit->valid_flg) ? $dataedit->valid_flg : null) , array('id' =>'valid_flg','name' => 'valid_flg')) }}
                            &nbsp{{ trans('Deactive') }}&nbsp
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <center>
                                <button type="button" name="button" class="btn btn-outline-success" onclick="formSubmit('{{ $display['button']}}');">{{ $display['button'] }}</button>
                                <button type="button" class="btn btn-outline-dark page-return" data-href="{{ route('students.list') }}" data-act="Cancel">Cancel</button>
                            </center>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection