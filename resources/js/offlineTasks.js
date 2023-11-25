// Create an IndexedDB database
const db = openDB('task-manager', 1);

// Create an object store named "tasks"
db.createObjectStore('tasks', {
    keyPath: 'id',
    autoIncrement: true
});

// Function to store a task in IndexedDB
function storeTask(task) {
    const transaction = db.transaction(['tasks'], 'readwrite');
    const taskStore = transaction.objectStore('tasks');
    taskStore.add(task);
    transaction.oncomplete = () => {
        console.log('Task stored successfully');
    };
    transaction.onerror = (error) => {
        console.error('Error storing task:', error);
    };
}

// Function to retrieve tasks from IndexedDB
function retrieveTasks() {
    const transaction = db.transaction(['tasks'], 'readonly');
    const taskStore = transaction.objectStore('tasks');
    const tasks = [];
    taskStore.openCursor().onsuccess = (event) => {
        const cursor = event.target.result;
        if (cursor) {
            tasks.push(cursor.value);
            cursor.continue();
        } else {
            console.log('Tasks retrieved successfully');
            // Display the retrieved tasks
            displayTasks(tasks);
        }
    };
    transaction.onerror = (error) => {
        console.error('Error retrieving tasks:', error);
    };
}
