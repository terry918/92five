@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.myWeeklyProjectReportTitle')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <!-- Time Sheet Detail -->
        <div class="work-report-title">{{trans('92five.weeklyReportTitle')}} {{Sentry::getUser()->first_name}} {{Sentry::getUser()->last_name}} {{trans('92five.reportTitle2')}} {{App::make('date')}} {{trans('92five.monthlyReportTitle3')}} {{$data['projectName']}}</div>
        <div class="timesheet-detail-main">
          <!-- Calender Slider -->
          <div class="jcarousel-wrapper">
            <div class="jcarousel">
              <ul>
                @foreach ($week as $day)
                <li class={{$day['class']}} id="">
                  <span class="c_day">{{$day['dayofweek']}}</span>
                  <span class="c_date">{{$day['day']}}</span>
                  <span class="c_month">{{$day['month']}}</span>
                  <span class="c_year">{{$day['year']}}</span>
                </li>
                @endforeach
              </ul>
            </div>
            <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
            <a href="#" class="jcarousel-control-next">&rsaquo;</a>
            <p class="jcarousel-pagination"></p>
          </div>
        </div>
        <!-- Summery -->
        <div class="report-summay">
          <h3>{{trans('92five.summary')}}</h3>
          <div class="row-fluid report-summay-inner">
            <!-- Left -->
            <div class="span6 summary-left">
              <div class="summary-detail-1">{{trans('92five.totalWorkingHours')}} : <strong>{{$data['totalTime']['hours']}}</strong> {{trans('92five.hours')}}<strong>{{$data['totalTime']['mins']}}</strong> {{trans('92five.minutes')}}</div>
              <div class="task-worked">
                <h4>{{trans('92five.taskWorkedOn')}}:</h4>
                <ul class="task-worked-list">
                  @if(sizeof($data['tasks'] !== 0))
                  @foreach($data['tasks'] as $task)
                  <li> {{$task['name']}} - <span>{{$task['hours']}}</span> {{trans('92five.hours')}} <span> {{$task['mins']}}</span> {{trans('92five.minutes')}}</li>
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
            <!-- Right -->
            <div class="span6 summary-right"><canvas id="weekChart" height="306" width="408"></canvas></div>
          </div>
        </div>
        @for( $i=0; $i < 7; $i++)
        <div class="report-summay">
          <h3>{{ new ExpressiveDate($dates[$i])}}</h3>
          @if(sizeof($data['entries'][$i]) == 0)
          <div class="row-fluid report-summay-inner">
            <div class="summary-detail-4">{{trans('92five.nullWeeklyEntry')}}</div>
          </div>
          @endif
        </div>
        @if(sizeof($data['entries'][$i]) != 0)
        <div class="row-fluid timesheet-detail" id="timesheet-detail">
          @foreach($data['entries'][$i] as $entry)
          <div class="">
            <div class="timesheet-box">
              <div class="row-fluid timesheet-detail-2">
                <div class="span5">{{trans('92five.workedOn')}} : </div>
                <div class="span7">{{$entry['title']}}</div>
              </div>
              <div class="timesheet-detail-3"></div>
              <div class="workingtime">{{$entry['total_hours']}} {{trans('92five.hours')}} {{$entry['total_minutes']}} {{trans('92five.minutes')}}</div>
              <div class="timesheet-time">{{trans('92five.from')}} {{date('g:ia', strtotime($entry['start_time']))}} {{trans('92five.till')}} {{date('g:ia', strtotime($entry['end_time']))}}</div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">{{trans('92five.details')}}:</div>
                @if($entry['details'] == null)
                <div class="span7">[{{trans('92five.noDetails')}}]</div>
                @else
                <div class="span7">{{$entry['details']}}</div>
                @endif
              </div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">{{trans('92five.task')}}:</div>
                @if($entry['task_id'] == null)
                <div class="span7">[{{trans('92five.noTask')}}]</div>
                @else
                <div class="span7">{{$entry['task']['name']}}</div>
                @endif
              </div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">{{trans('92five.remarks')}}:</div>
                @if($entry['details'] == null)
                <div class="span7">[{{trans('92five.noRemarks')}}]</div>
                @else
                <div class="span7">{{$entry['remarks']}}</div>
                @endif
              </div>
              <div class="timesheet-create">{{trans('92five.updatedOn')}} {{$entry['updated_at']}}</div>
            </div>
          </div>
          @endforeach
        </div>
        @endif
        @endfor
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')
{{ HTML::style('assets/css/dashboard/jcarousel.responsive.css') }}
{{ HTML::script('assets/js/jquery/jquery.jcarousel.min.js') }}
{{ HTML::script('assets/js/jquery/jcarousel.responsive.js') }}
{{ HTML::script('assets/js/dashboard/ChartNew.js') }}
<style>
      canvas{
      }
</style>
<script>
var lineChartData = {
  labels: {{$chartWeek}},
  datasets: [{
      fillColor: "rgba(52, 152, 219,1.0)",
      strokeColor: "rgba(220,220,220,1)",
      pointColor: "rgba(41, 128, 185,1.0)",
      pointStrokeColor: "#fff",
      data: {{$chartWeekData}}
    }
  ],
}
var options = {
  scaleFontFamily: "'Lato_reg'",
  scaleFontColor: "#000",
  scaleOverride: true,
  scaleSteps: 6,
  scaleStepWidth: 2,
  scaleStartValue: null,
  scaleShowLabels: true,
  annotateDisplay: true,
  yAxisLabel: "Hours",
  yAxisFontSize: 12,
}
var myLine = new Chart(document.getElementById("weekChart").getContext("2d")).Line(lineChartData, options);
</script>
@stop

