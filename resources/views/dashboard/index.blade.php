<!-- Левая колонка -->
<div>
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-4">Профиль</h2>
        <p>Имя: {{ $user->name }}</p>
        <p>Фамилия: {{ $user->surname }}</p>
    </div>

    <div class="bg-white shadow rounded-lg p-4 mt-6">
        <h2 class="text-lg font-semibold mb-4">Группы</h2>
        <ul>
            @forelse ($groups as $group)
                <li class="text-blue-600">{{ $group->name }}</li>
            @empty
                <li>Нет групп</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Правая колонка -->
<div class="col-span-2">
    <div class="grid grid-cols-3 gap-4">
        <!-- Таски исполнителя -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Назначенные задачи</h2>
            <ul>
                @forelse ($assignedTasks as $task)
                    <li>
                        <strong>{{ $task->title }}</strong>
                        <span class="text-sm text-gray-600">
                            (Группа: {{ $task->group->name ?? 'Без группы' }})
                        </span>
                    </li>
                @empty
                    <li>Нет задач</li>
                @endforelse
            </ul>
        </div>

        <!-- Таски команды без исполнителя -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Задачи без исполнителя</h2>
            <ul>
                @forelse ($groupTasksNoAssignee as $task)
                    <li>
                        <strong>{{ $task->title }}</strong>
                        <span class="text-sm text-gray-600">
                            (Создано: {{ $task->creator->first_name ?? '' }})
                        </span>
                    </li>
                @empty
                    <li>Нет задач</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
