@extends('layouts.main')

@section('content-main')
<x-chart-box id="chart_box"/>

<h1 class="mb-5">Главная панель</h1>
<div class="col-6">
    <h4>Статистика заявок</h4>
    <p>Статистика заявок по дням</p>
    <div class="col-3 mb-4">
        <x-select-month id="chart1-select" selected="0"/>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" width="600" viewBox="0 0 600 300" height="300" id="svg1"></svg>
</div>

<script>
    var date = new Date();
    var month = date.getMonth() + 1;
    $(document).ready(function(){

        $("#chart1-select").on("change", function(){
            var month = this.value;
            $.getJSON(`/orders/get/2022/${month}`, function(response){
                if(response.status == undefined){
                    return;
                }
                if(response.status != 'success'){
                    return;
                }

                window.chart.set(response.data);
                window.chart.month = month;
                window.chart.draw();
            });
        });

        $("#chart1-select").val(month);
        $("#chart1-select").change();
    });
</script>
@endsection