<x-app-layout title="Dashboard">
    <section class="hero-panel p-4 p-lg-5 mb-4" style="--hero-image: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1600&q=85')">
        <div class="content">
            <div class="hero-kicker mb-2">TechFlow operations dashboard</div>
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <h1 class="display-6 fw-bold mb-0">Run your technology workstreams with clarity and speed.</h1>
                <span class="badge bg-secondary">{{ auth()->user()->role_label }}</span>
            </div>
            <p class="lead mb-4">See your engineering tasks, incident response items, and delivery milestones in one technology-focused workspace.</p>
            @can('create', App\Models\TaskAKL::class)
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-primary btn-lg" href="{{ route('tasks.create') }}">Create task</a>
                    @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('reminders.deadlines') }}">
                            @csrf
                            <button class="btn btn-light btn-lg" type="submit">Send deadline reminders</button>
                        </form>
                    @endif
                </div>
            @endcan
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card metric surface-card"><div class="card-body"><div class="text-muted">Total tech tasks</div><div class="h2">{{ $totalTasks }}</div></div></div></div>
        <div class="col-md-3"><div class="card metric surface-card"><div class="card-body"><div class="text-muted">Open work items</div><div class="h2">{{ $openTasks }}</div></div></div></div>
        <div class="col-md-3"><div class="card metric surface-card"><div class="card-body"><div class="text-muted">Completed tasks</div><div class="h2">{{ $completedTasks }}</div></div></div></div>
        <div class="col-md-3"><div class="card metric surface-card"><div class="card-body"><div class="text-muted">Due soon</div><div class="h2">{{ $dueSoonTasks }}</div></div></div></div>
    </div>

    @php
        $projects = [
            [
                'name' => 'Incident Response',
                'task' => 'Resolve priority bugs and notify stakeholders before the next release.',
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Release Planning',
                'task' => 'Coordinate deployment tasks, QA checks, and rollout approvals.',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Feature Build',
                'task' => 'Track development, testing, and engineering review for new features.',
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=900&q=80',
            ],
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="h4 mb-1">Featured technology workflows</h2>
            <p class="text-muted mb-0">Technology tasks connected to your engineering, operations, and release work.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        @foreach($projects as $project)
            <div class="col-md-4">
                <div class="card vehicle-card">
                    <img src="{{ $project['image'] }}" alt="{{ $project['name'] }}">
                    <div class="card-body">
                        <span class="badge mb-2">TechFlow</span>
                        <h3 class="h5 mb-1">{{ $project['name'] }}</h3>
                        <p class="text-muted mb-0">{{ $project['task'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card surface-card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Recent tech tasks</h2>
                    @forelse($recentTasks as $task)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <a class="fw-semibold" href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                                <div class="small text-muted">{{ optional($task->assignee)->name ?? 'Unassigned' }} | {{ optional($task->deadline)->format('d M Y') ?? 'No deadline' }}</div>
                            </div>
                            <span class="badge text-bg-light status-pill">{{ str_replace('_', ' ', $task->status) }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No tasks yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card surface-card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Technology categories</h2>
                    @foreach($categories as $category)
                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge me-2" style="background: {{ $category->color }}">&nbsp;</span>{{ $category->name }}</span>
                            <span class="text-muted">{{ $category->tasks_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

