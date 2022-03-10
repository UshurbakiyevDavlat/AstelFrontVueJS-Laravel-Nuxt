@component('mail::message')

<h1>Новый запрос на обратный звонок</h1>
<p>
    Создан: {{ ($callback->created_at) }} ( {{ $callback->created_at->diffForHumans() }} )<br/>
    Перейти на сайт <b><a style="text-decoration: none;" href="{{ backpack_url('callback', ['id' => $callback->id]) }}/show">admin.astel.kz</a></b>
</p>
<br/>
<div>
    <table>
        <tbody>
            <tr>
                <td>{{ trans('admin.full_name') }}</td>
                <td>{{ $callback->name }}</td>
            </tr>
            <tr>
                <td>{{ trans('admin.phone') }}</td>
                <td><a href="tel:{{ $callback->phone }}">{{ $callback->phone }}</a></td>
            </tr>
            <tr>
                <td>{{ trans('admin.email') }}</td>
                <td><a href="mailto:{{ $callback->email }}">{{ $callback->email }}</a></td>
            </tr>
            <tr>
                <td>{{ trans('admin.city') }}</td>
                <td>{{ $callback->city }}</td>
            </tr>
            <tr>
                <td>{{ trans('admin.message') }}</td>
                <td>{{ $callback->message }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endcomponent
