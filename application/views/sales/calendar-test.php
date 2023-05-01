<div class="container mt-2">
    <h1>Ejemplo de calendarios con color</h1>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita perspiciatis impedit doloribus? Commodi sequi nemo vero amet, rem delectus ut placeat sint ipsam quaerat ratione laudantium libero non repellat totam.</p>
    <hr>
    <div class="btn-group" id="btn-calendars">
        <button class="btn btn-primary">Calendar 1</button>
        <button class="btn btn-success">Calendar 2</button>
        <button class="btn btn-warning">Calendar 3</button>
    </div>
    <h4 class="text-center">Calendarios</h4>
    <div class="row">
        <div class="col-sm-4">
            <?php $this->load->view('components/calendar', array('id' => 'calendar1')); ?>
        </div>
        <div class="col-sm-4">
            <?php $this->load->view('components/calendar', array('id' => 'calendar2')); ?>
        </div>
        <div class="col-sm-4">
            <?php $this->load->view('components/calendar', array('id' => 'calendar3')); ?>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function(evt) {
    console.log('documento cargado');
    $('.calendar').not($('#calendar1')).datepicker({
        minDate: '-7D',
        maxDate: '+7D'
    });

    // availableDates = ['20-05-2019', '21-05-2019', '24-05-2019', '26-05-2019'];
    var availableDates = [];
    availableDates.push(new Date(2019, 4, 10).toISOString());
    availableDates.push(new Date(2019, 4, 11).toISOString());
    availableDates.push(new Date(2019, 4, 12).toISOString());
    availableDates.push(new Date(2019, 4, 16).toISOString());
    availableDates.push(new Date(2019, 4, 17).toISOString());
    availableDates.push(new Date(2019, 4, 18).toISOString());
    availableDates.push(new Date(2019, 4, 20).toISOString());
    availableDates.push(new Date(2019, 4, 21).toISOString());
    availableDates.push(new Date(2019, 4, 22).toISOString());
    $('#calendar1').datepicker({
        minDate: new Date(2019, 3, 5),
        maxDate: new Date(2019, 5, 10),
        beforeShowDay: function(d) {
            // var dmy = d.getDate()
            // if (d.getDate() < 10) dmy = "0" + dmy;
            // dmy += "-";

            // if (d.getMonth() < 9)
            //     dmy += "0" + (d.getMonth() + 1);
            // else
            //     dmy += (d.getMonth() + 1)
            // dmy += "-";

            // dmy += d.getFullYear();
            // console.log(dmy + ' : ' + ($.inArray(dmy, availableDates)));
            console.log(d.toISOString());
            var cl = "bg-primary";
            if ($.inArray(d.toISOString(), availableDates) != -1) {
                // console.log(d);
                // console.log(true);
                return [true, cl, "Available"];
            } else {
                // console.log(d);
                // console.log(false);
                return [true, "", "unAvailable"];
            }
        }
    });

    $('#btn-calendars .btn:first-of-type').on('click', function() {
        console.log('boton 1');
        availableDates.splice(3, 0, new Date(2019, 4, 13).toISOString());
        availableDates.splice(4, 0, new Date(2019, 4, 14).toISOString());
        availableDates.splice(5, 0, new Date(2019, 4, 15).toISOString());
        availableDates.splice(6, 6);
        $("#calendar1").datepicker("option", {
            minDate: null,
            maxDate: null
        });
        // $("#calendar1").datepicker("destroy");
        $('#calendar1').datepicker({
            minDate: new Date(2019, 3, 5),
            maxDate: new Date(2019, 5, 10),
            beforeShowDay: function(d) {
                // console.log('ok');
                // var dmy = d.getDate()
                // if (d.getDate() < 10) dmy = "0" + dmy;
                // dmy += "-";

                // if (d.getMonth() < 9)
                //     dmy += "0" + (d.getMonth() + 1);
                // else
                //     dmy += (d.getMonth() + 1)
                // dmy += "-";

                // dmy += d.getFullYear();
                var cl = "bg-primary";
                if ($.inArray(d.toISOString(), availableDates) != -1) {
                    return [true, cl, "Available"];
                } else {
                    return [true, "", "unAvailable"];
                }
            }
        });
    });
    $('#btn-calendars .btn:nth-child(2)').on('click', function() {
        console.log('boton 2')
    })
    $('#btn-calendars .btn:last-of-type').on('click', function() {
        console.log('boton 3');
    })

    function pintarFechas() {

    }
})

// var SelectedDates = {};
// SelectedDates[new Date('04/05/2019')] = new Date('04/05/2019');
// SelectedDates[new Date('05/04/2019')] = new Date('05/04/2019');
// SelectedDates[new Date('05/05/2019')] = new Date('05/05/2019');

// $('#txtDate').datepicker({
//     beforeShowDay: function(date) {
//         var Highlight = SelectedDates[date];
//         if (Highlight) {
//             return [true, "Highlighted", Highlight];
//         } else {
//             return [true, '', ''];
//         }
//     }
// });
</script>