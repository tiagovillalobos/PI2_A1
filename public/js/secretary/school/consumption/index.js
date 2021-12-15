var today = new Date()

let datepicker = $('#consumption-created-at').datepicker({
    language: 'pt-BR',
    autoclose: true,
    showOnFocus: false,
    endDate: today
})

datepicker.val(today.toLocaleDateString('pt-BR', {timeZone: 'America/Sao_Paulo'}))

$('#consumption-created-at-datepicker-icon').click(function(){
    datepicker.datepicker('show')
})

function fetchConsumptions() {

    $('[id^="food-"]').text('00')

    $('[id^="food-"]').hide()

    $.ajax({
        url: datepicker.data('url'),
        data: {
            consumption: {
                created_at: datepicker.val()
            }
        },

        success:function(response) {
            
            if(response.length > 0) {

                response.forEach(function(food){
                    $(`#food-${food.food_id}-amount_consumed`).text(food.amount_consumed).hide().fadeIn()
                })
            }

        }
    })

    $('[id^="food-"]').fadeIn()

}

if(datepicker.val()) fetchConsumptions()

datepicker.on('changeDate', fetchConsumptions)