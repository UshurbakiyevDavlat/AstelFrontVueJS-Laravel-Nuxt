@component('mail::message')

<h1>Новый отклик га вакансию {{ $jobApplication->vacancy->name }}</h1>
<p>
    Создан: {{ ($jobApplication->created_at) }} ( {{ $jobApplication->created_at->diffForHumans() }} )<br/>
    Перейти на сайт <b><a style="text-decoration: none;" href="{{ backpack_url('jobapplication', ['id' => $jobApplication->id]) }}/show">admin.astel.kz</a></b>
</p>
<br/>
<div>
    <table>
        <tbody>
            <tr>
                <td>{{ trans('admin.jobjob_application') }}</td>
                <td><a href="{{ backpack_url('vacancy', ['id' => $jobApplication->vacancy_id]) }}/show">{{ $jobApplication->vacancy->name }}</a></td>
            </tr>
            <tr>
                <td>{{ trans('admin.full_name') }}</td>
                <td>{{ $jobApplication->full_name }}</td>
            </tr>
            <tr>
                <td>{{ trans('admin.phone') }}</td>
                <td><a href="tel:{{ $jobApplication->phone }}">{{ $jobApplication->phone }}</a></td>
            </tr>
            <tr>
                <td>{{ trans('admin.email') }}</td>
                <td><a href="mailto:{{ $jobApplication->email }}">{{ $jobApplication->email }}</a></td>
            </tr>
            <tr>
                <td>{{ trans('admin.message') }}</td>
                <td>{{ $jobApplication->message }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endcomponent
