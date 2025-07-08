<div id="app" class="container py-5">
    <h1 class="mb-4 text-center">📝 Мой To-Do List</h1>

    <!-- Quill Editor -->
    <div id="editor" class="mb-3"></div>
    <button class="btn btn-primary mb-4" @click="createTask">Добавить задачу</button>

    <!-- Tasks Table -->
    <div v-if="tasks.length" class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th style="width: 60%;">Задача</th>
                <th style="width: 20%;">Статус</th>
                <th style="width: 20%;">Действие</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td v-html="task.title"></td>
                <td>
                    <span v-if="task.is_done" class="badge bg-success">Готово</span>
                    <span v-else class="badge bg-warning text-dark">В ожидании</span>
                </td>
                <td>
                    <button v-if="!task.is_done"
                            class="btn btn-sm btn-outline-success"
                            @click="markAsDone(task.id)">
                        Завершить
                    </button>
                    <span v-else class="text-muted">—</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="text-muted text-center">Пока нет задач. Добавьте одну выше!</div>
</div>

<footer class="text-center py-3 text-muted">
    Реализовано Mikhail Shapshay. Все права защищены.
</footer>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.10/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            tasks: [],
            quill: null
        },
        mounted() {
            this.quill = new Quill('#editor', { theme: 'snow' });
            this.fetchTasks();
        },
        methods: {
            fetchTasks() {
                axios.get('/api/list').then(res => this.tasks = res.data);
            },
            createTask() {
                const html = this.quill.root.innerHTML.trim();
                if (!html || html === '<p><br></p>') {
                    alert('Введите текст задачи.');
                    return;
                }
                axios.post('/api/create',
                    { title: html },
                    { headers: { 'Content-Type': 'application/json' } }
                ).then(res => {
                    this.tasks.push(res.data);
                    this.quill.setContents([]);
                }).catch(err => console.error(err));
            },
            markAsDone(id) {
                axios.post(`/api/update/${id}`).then(res => {
                    const updated = res.data;
                    const task = this.tasks.find(t => t.id === updated.id);
                    if (task) task.is_done = true;
                });
            }
        }
    });
</script>