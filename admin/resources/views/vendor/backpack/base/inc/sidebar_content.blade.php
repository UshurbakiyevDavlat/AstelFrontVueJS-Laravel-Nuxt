<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon la la-link'></i> {{ trans_choice('admin.pages', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('settings') }}'><i class='nav-icon la la-cogs'></i> {{ trans_choice('admin.settings', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('city') }}'><i class='nav-icon la la-map-marked'></i> {{ trans_choice('admin.cities', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('translation') }}'><i class='nav-icon la la-flag-checkered'></i> {{ trans_choice('admin.translations', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('post') }}'><i class='nav-icon la la-poll-h'></i> {{ trans_choice('admin.posts', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('project') }}'><i class='nav-icon la la-tasks'></i> {{ trans_choice('admin.projects', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('service') }}'><i class='nav-icon la la-cog'></i> {{ trans_choice('admin.services', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('vacancy') }}'><i class='nav-icon la la-address-card'></i> {{ trans_choice('admin.vacancies', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('partner') }}'><i class='nav-icon la la-handshake'></i> {{ trans_choice('admin.partners', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('manager') }}'><i class='nav-icon la la-user-circle'></i> {{ trans_choice('admin.managers', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('certificate') }}'><i class='nav-icon la la-certificate'></i> {{ trans_choice('admin.certificates', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('license') }}'><i class='nav-icon la la-copyright'></i> {{ trans_choice('admin.licenses', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('callback') }}'><i class='nav-icon la la-phone'></i> {{ trans_choice('admin.callbacks', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('service-callback') }}'><i class='nav-icon la la-briefcase'></i> {{ trans_choice('admin.service_callbacks', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('partnership') }}'><i class='nav-icon la la-briefcase'></i> {{ trans_choice('admin.partnership', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('jobapplication') }}'><i class='nav-icon la la-user-plus'></i> {{ trans_choice('admin.job_applications', 2) }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}\"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
