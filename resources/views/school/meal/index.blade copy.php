@extends('layouts.app')

@section('title', 'Cadastrar Cardápio Diário')

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/gijgo/gijgo.min.css') }}">
@endpush

@section('content')
<form id="meal-form" action="{{ route('school.meal.store') }}" method="POST">
    @csrf
    <div class="mb-4">
        <div class="form-group">
            <div class="row">
                <div class="col-auto d-flex align-items-center py-0 pr-0">
                    <label class="my-auto">Dia:</label>
                </div>
                <div class="col-md-4">
                    <input id="meal-created-at" type="text" name="meal[created_at]" class="form-control @error('meal.created_at') is-invalid @enderror" placeholder="Buscar..." readonly value="{{ old('meal.created_at') }}" data-url="{{ route('school.meal.index') }}">
                    @error('meal.created_at')
                    <span class="text-danger d-block small">
                        {{ $errors->first('meal.created_at') }}
                    </span>
                    @enderror
                </div>
            </div>


        </div>
    </div>

    <form action="{{ route('school.meal.store')}}" method="POST">
        @csrf        
        <div class="col-md-3">
            <div class="form-group">
            </div>
        </div>
        <div class="form-group">
        <input type="hidden" name="meal[mealtime]" list="mealtimelist" class="form-control {{ $errors->has('meal.mealtime') ? 'is-invalid' : '' }}" value="{{ old('meal.mealtime') }}">
            <label for="mealtimelist">Escolha o horário da refeição:</label>
            <select id="mealtimelist">
                <option value="">--escolha uma opção--</option>
                <option value="breakfast">café da manhã</option>
                <option value="lunch">almoço</option>
                <option value="afternoon snack">lanche da tarde</option>
                <option value="dinner">jantar</option>
            </select>
            <!-- = document.getElementById("mealtimelist"); -->
            <div class="invalid-feedback">{{ $errors->first('meal.mealtime') }}</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="meal[name]" class="form-control {{ $errors->has('meal.name') ? 'is-invalid' : '' }}" placeholder="Refeição" value="{{ old('meal.name') }}">
                    <div class="invalid-feedback">{{ $errors->first('meal.name') }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="meal[amount]" class="form-control amount {{ $errors->has('meal.amount') ? 'is-invalid' : '' }}" placeholder="Refeições servidas" value="{{ old('meal.amount') }}">
                    <div class="invalid-feedback">{{ $errors->first('meal.amount') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="meal[repeat]" class="form-control repeat {{ $errors->has('meal.repeat') ? 'is-invalid' : '' }}" id="repeat" id="repeat[0]" placeholder="Repetições servidas" value="{{ old('meal.repeat') }}">
                    <div class="invalid-feedback">{{ $errors->first('meal.repeat') }}</div>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-success btn-block mt-3">
            Cadastrar
        </button>

    </form>


    @endsection

    @push('js')
    <script src="{{ asset('vendor/gijgo/gijgo.min.js') }}"></script>
    <script src="{{ asset('vendor/gijgo/messages.pt-br.js') }}"></script>
    <script src="{{ asset('vendor/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        $('#meal-created-at').datepicker({
            locale: 'pt-br',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'dd/mm/yyyy',
            showOnFocus: false,
            change: function(event) {
                $(this).valid()

                const url = $(this).data('url')
                const createdAt = $(this).val()
                let value = $(this).val()

                value = value === $(this).val() ? value : $(this).val()

                if (value === $(this))

                    console.log(value)


            },
        })

        $(document).on('change', '#meal-create-at', function() {
            console.log($(this).val())
        })

        $('.zero-left').mask('0#', {
            onKeyPress: function(value, event, currentField) {
                console.log(parseInt(value))
                value = parseInt(value)

                if (value <= 9 && value.toString().length < 2) {
                    $(currentField).val(`0${value.toString()}`)
                } else {
                    $(currentField).val(value)
                }
            }
        })

        jQuery.validator.setDefaults({
            errorElement: 'span',
            errorClass: 'invalid-feedback text-center',
            errorPlacement: function(error, element) {
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        })

        $('#meal-form').validate({
            rules: {
                'meal[created_at]': {
                    required: true
                },
                'meal[mealtime]': {
                    required: true
                }

            },
            messages: {
                'meal[created_at]': {
                    required: 'O campo dia é obrigatório.'
                }
            }
        })
        
        $("input[name^='meal']").each(function() {

            $(this).rules('add', {
                required: true,
                messages: {
                    required: 'Preenchimento obrigatório.'
                }
            })

        })
    </script>
    @endpush