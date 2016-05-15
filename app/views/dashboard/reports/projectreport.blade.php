@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.projectReport')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <div class="monthly_title">{{trans('92five.projectReportGeneratedOn')}}  {{App::make('date')}} {{trans('92five.monthlyReportTitle3')}} {{$project['project_name']}} </div>
        <div class="row-fluid monthly_detail_1">
          <div class="span5 report-summay monthly_calender">
            <h3>{{trans('92five.status')}}</h3>
            <div class="proj_status_main">
              <div class="row-fluid project_status">
                <div class="span6"><strong>{{trans('92five.startDate')}}: </strong>{{new ExpressiveDate($project['start_date'])}}</div>
                <div class="span6"><strong>{{trans('92five.endDate')}}: </strong>{{new ExpressiveDate($project['end_date'])}}</div>
              </div>
              <div class="proj_status_prog"> <input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#14b9d6" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}></div>
              <div class="proj_status_detail">{{trans('92five.status')}}: {{$project['status']}}</div>
            </div>
          </div>
          <div class="span7 report-summay">
            <h3>{{trans('92five.details')}}</h3>
            <div class="proj_status_main proj_summary">
              <div class="row-fluid">
                <div class="span7">
                  <h4>{{trans('92five.description')}}:</h4>
                  @if($project['description'] != null or $project['description'] != '')
                  <p>{{$project['description']}}</p>
                  @else
                  <div class="no_file" > [{{trans('92five.noDescriptionProject')}} ]</div>
                  @endif
                </div>
                <div class="span5">
                  <h4>{{trans('92five.files')}}:</h4>
                  @if(sizeof($project['files']) == 0)
                  <div class ="no_file" >
                    [ {{trans('92five.noFilesProjectText')}} ]
                  </div>
                  @else
                  <ul class="collaborators proj_summary_files files_1">
                    @foreach($project['files'] as $file)
                    <li><a href="#">
                      @if(strlen($file['file_name']) > 25)
                      {{substr($file['file_name'],0,18).' ...'}}
                      @else
                      {{$file['file_name']}}
                      @endif
                    </a>
                    <span class="view_proj_filedesc">{{$file['size']}} {{trans('92five.uploadedOn')}} {{new ExpressiveDate($file['uploaded_date'])}} {{trans('92five.by')}} {{User::where('id',$file['uploaded_by'])->pluck('first_name')}} {{User::where('id',$file['uploaded_by'])->pluck('last_name')}}</span>
                  </li>
                  @endforeach
                </ul>
                @endif
              </div>
            </div>
            <div class="row-fluid">
              <div class="span7">
                <h4>{{trans('92five.note')}}:</h4>
                @if($project['note'] != null or $project['note'] != '')
                <p> {{$project['note']}}</p>
                @else
                <div class ="no_file" >
                  [ {{trans('92five.noNoteProjectText')}} ]
                </div>
                @endif
              </div>
              <div class="span5">
                <h4>{{trans('92five.client')}}:</h4>
                @if($project['project_client'] == null or $project['project_client'] == '')
                <div class ="no_file" >
                  [ {{trans('92five.noClientProjectText')}} ]
                </div>
                @else
                <p>{{$project['project_client']}}</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="report-summay">
        <h3>{{trans('92five.Tasks')}}</h3>
        <div class="row-fluid report-summay-inner monthly_tasks">
          <!--<div class="summary-detail-4">No Entries on this date has been recorded</div>-->
          <div class="row-fluid">
            <!-- Left -->
            <div class="span6 summary-left">
              <div class="summary-detail-1">{{$project['compl_tasks']}} {{trans('92five.outOf')}} {{$project['total_tasks']}} {{trans('92five.taskCompleted')}}</div>
              <div class="task-worked">
                @if(array_key_exists('taskList',$project))
                <ul class="task-worked-list proj_task_list">
                  @foreach($project['taskList'] as $tList)
                  @if($tList['status'] == 'active')
                  <li>{{$tList['name']}} - <span class="proj_status_1">{{trans('92five.active')}}</span></li>
                  @elseif($tList['status'] == 'completed')
                  <li>{{$tList['name']}} - <span class="proj_status_2">{{trans('92five.completed')}}</span></li>
                  @elseif($tList['status'] == 'delayed')
                  <li>{{$tList['name']}} - <span class="proj_status_3">{{trans('92five.delayed')}}</span></li>
                  @endif
                  @endforeach
                </ul>
                @endif
              </div>
            </div>
            <!-- Right -->
            <div class="span6 summary-right"><canvas id="taskchart" height="306" width="408"></canvas></div>
          </div>
        </div>
      </div>
      @if(array_key_exists('tasks',$project))
      @foreach($project['tasks'] as $task)
      <div class="report-summay">
        <h3>{{$task['task'][0]['name']}}</h3>
        <div class="row-fluid report-summay-inner proj_task_name">
          <div class="row-fluid">
            <div class="span4">
              <h4>{{trans('92five.status')}}:</h4>
              <div class="row-fluid view_comp_deleyed">
                @if($task['task'][0]['status'] == 'active')
                <div class="task_no_inner view_task_hr" id ="task_no_inner">{{sprintf("%02s", $task['task'][0]['num_status'])}} <p><a href="#">{{trans('92five.daysRemaining')}}</a></p></div>
                @elseif($task ['task'][0]['status'] == 'completed')
                <div class="task_compete view_task_hr2">{{trans('92five.completedOn')}} {{new ExpressiveDate($task['task'][0]['completed_on'])}}</div>
                @elseif($task['task'][0]['status'] == 'delayed')
                <div class="task_delayed view_task_hr3">{{trans('92five.delayed')}}</div>
                @endif
              </div>
            </div>
            <div class="span4">
              <h4>{{trans('92five.note')}}:</h4>
              @if($task['task'][0]['note'] != null)
              <p>{{$task['task'][0]['note']}}</p>
              @else
              <div class="note_for_task">[{{trans('92five.noNoteTaskText')}}]</div>
              @endif
            </div>
            <div class="span4">
              <h4>{{trans('92five.subTasks')}}:</h4>
              <div class="span12 sub_task_data selected">
                @if($task['subtasks'] == null)
                {{trans('92five.noSubtasks')}}
                @else
                <ul class="test_sub_task">
                  @foreach($task['subtasks'] as $subtask)
                  @if($subtask['status'] == 'active')
                  <li><a href="#">{{$subtask['text']}}</a></li>
                  @else
                  <li><a href="#" class="sub_task_select"> {{$subtask['text']}}</a></li>
                  @endif
                  @endforeach
                </ul>
                @endif
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <div class="proj_start"><strong>{{trans('92five.startDate')}}:</strong>{{new ExpressiveDate($task['task'][0]['start_date'])}}</div>
              <div class="proj_start"><strong>{{trans('92five.endDate')}}:</strong>{{new ExpressiveDate($task['task'][0]['end_date'])}}</div>
            </div>
            <div class="span4">
              <h4>{{trans('92five.assignee')}}:</h4>
              @if(array_key_exists('userTime',$task))
              <div class="file-data-main asignee_sec">
                @foreach($task['userTime'] as $entry)
                <div class="view-upload">{{$entry['userName']}} - {{$entry['totalTime']['hours']}} {{trans('92five.hoursAnd')}} {{$entry['totalTime']['mins']}} {{trans('92five.minutes')}}</div>
                @endforeach
              </div>
              @else
              <div class="file-data-main asignee_sec">
                @foreach($task['task'][0]['users'] as $user)
                <div class="view-upload"> {{$user['first_name']." ".$user['last_name']}}</div>
                @endforeach
              </div>
              @endif
            </div>
            <div class="span4">
              <h4>{{trans('92five.files')}}:</h4>
              @if($task['task'][0]['files'] == null)
              <div class ="no_file" >
                [ {{trans('92five.noFilesTaskText')}} ]
              </div>
              @else
              <ul class="collaborators proj_summary_files files_1">
                @foreach($task['task'][0]['files'] as $file)
                <li><a href="">
                  @if(strlen($file['file_name']) > 30)
                  {{substr($file['file_name'],0,25).' ...'}}
                  @else
                  {{$file['file_name']}}
                  @endif
                </a>
                <span class="view_proj_filedesc">{{$file['size']}}. {{trans('92five.uploadedOn')}} {{new ExpressiveDate($file['uploaded_date'])}} {{trans('92five.by')}} {{User::where('id',$file['uploaded_by'])->pluck('first_name')}} {{User::where('id',$file['uploaded_by'])->pluck('last_name')}}</span>
              </li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>
        <div class="proj_last_update">{{trans('92five.lastUpdatedBy')}} {{User::where('id',$task['task'][0]['updated_by'])->pluck('first_name')}} {{User::where('id',$task['task'][0]['updated_by'])->pluck('last_name')}} {{trans('92five.on')}} {{$task['task'][0]['updated_at']}}</div>
      </div>
    </div>
    @endforeach
    @endif
    @if(array_key_exists('users',$project))
    <div class="report-summay user_collaborators_main">
      <h3>{{trans('92five.users')}} / {{trans('92five.collaborators')}}</h3>
      <div class="row-fluid user_collaborators">
        @foreach($project['users'] as $user)
        <div class="collaborators_list">
          <h4>{{$user['userName']}}</h4>
          <div class="collaborators_name"><img src="{{url('assets/images/profilepics/')}}/{{$user['userId']}}.png" alt=""></div>
          <div class="collaborators_time"><span>{{$user['totalTime']['hours']}}</span> {{trans('92five.hoursAnd')}} </div>
          <div class="collaborators_time"><span>{{$user['totalTime']['mins']}}</span> {{trans('92five.minutes')}}</div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</div>
</div>
</div>
@stop
@section('endjs')
{{ HTML::script('assets/js/jquery/jquery.knob.js') }}
{{ HTML::script('assets/js/dashboard/taskcompleted.js') }}
{{ HTML::script('assets/js/dashboard/ChartNew.js') }}
<style>
      canvas{
      }
    </style>
<script>
var taskdata = [{
    value: {{$project['compl_tasks']}},
    color: "#2a6d1a",
    title: "Completed Tasks"

  }, {
    value: {{$project['active_tasks']}},
    color: "#ee8e11",
    title: "Active Tasks"

  }, {
    value: {{$project['delay_tasks']}},
    color: "#ca0505",
    title: "Delayed Tasks"
  }
]
var options = {
  scaleFontFamily: "'Lato_reg'",
  scaleFontColor: "#000",
  scaleOverride: true,
  annotateDisplay: true,
}
var myLine = new Chart(document.getElementById("taskchart").getContext("2d")).Doughnut(taskdata, options);
</script>
@stop
