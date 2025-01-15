import React, { useState, useEffect } from 'react';
import { ListTodo, Settings, Menu, X, LogOut, Plus, Pencil, Trash2, ShieldCheck } from 'lucide-react';
import { formatDistance, format } from "date-fns";
import { ptBR } from "date-fns/locale"; // Para exibir em português


interface Task {
  id: number;
  title: string;
  description: string;
  category_id: number;
  finished_at: string | null;
  situacao_id: number;
  user_id: number;
  created_at: string;
  updated_at: string;
}

interface Category {
  id: number;
  name: string;
}
interface Situacao {
  id: number;
  name: string;
}

interface DashboardProps {
  token: string;
}

function Dashboard({ token }: DashboardProps) {
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const [activeMenu, setActiveMenu] = useState('tasks');
  const [tasks, setTasks] = useState<Task[]>([]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [situacao, setSituacao] = useState<Situacao[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState('');
  const [searchTerm, setSearchTerm] = useState('');


  // Form states
  const [isEditing, setIsEditing] = useState(false);
  const [editingTask, setEditingTask] = useState<Task | null>(null);
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    category_id: '',
    situacao_id: 1,
  });
  const [showForm, setShowForm] = useState(false);

  // Fetch categories
  const fetchCategories = async () => {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/categoria', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) throw new Error('Failed to fetch categories');

      const data = await response.json();
      console.log("data category", data);
      setCategories(data.categorias.data);
    } catch {
      setError('Failed to load categories');
    }
  };

  const fetchSituacoes = async () => {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/situacao', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
      if (!response.ok) throw new Error('Failed to fetch situacoes');

      const data = await response.json();
      console.log("data situacao", data);
      setSituacao(data.situacao);
    } catch {
      setError('Failed to load Situacao');
    }
  };

  // Fetch tasks
  const fetchTasks = async () => {
    setIsLoading(true);
    try {
      const response = await fetch('http://127.0.0.1:8000/api/task', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) throw new Error('Failed to fetch tasks');

      const data = await response.json();
      console.log("data:", data);
      setTasks(data.task);
    } catch {
      setError('Failed to load tasks');
      setTasks([]); // Reset tasks to empty array on error
    } finally {
      setIsLoading(false);
    }
  };

  const filteredTasks = tasks.filter((task) =>
    task.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    task.description.toLowerCase().includes(searchTerm.toLowerCase())
  );


  useEffect(() => {
    fetchCategories();
    fetchSituacoes();
    fetchTasks();
  }, [token]);

  // Create task
  const handleCreateTask = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    try {
      const response = await fetch('http://127.0.0.1:8000/api/task', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          ...formData,
          category_id: parseInt(formData.category_id)
        })
      });

      if (!response.ok) throw new Error('Failed to create task');

      const result = await response.json();
      if (result.status) {
        await fetchTasks();
        setShowForm(false);
        setFormData({ title: '', description: '', category_id: '', situacao_id: 1 });
      } else {
        throw new Error(result.message || 'Failed to create task');
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to create task');
    } finally {
      setIsLoading(false);
    }
  };

  // Update task
  const handleUpdateTask = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!editingTask) return;

    setIsLoading(true);
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/task/${editingTask.id}`, {
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          ...formData,
          category_id: parseInt(formData.category_id)
        })
      });

      if (!response.ok) throw new Error('Failed to update task');

      await fetchTasks();
      setIsEditing(false);
      setEditingTask(null);
      setFormData({ ...formData, situacao_id: 2 });
      setShowForm(false);
    } catch {
      setError('Failed to update task');
    } finally {
      setIsLoading(false);
    }
  };

  const handleMarkCheckedTask = async (editingTask: Task) => {
    if (!editingTask) return;
    console.log("dados editingTask ", editingTask);
    setIsLoading(true); // Ativa o loading do formulário
    try {
      const finishedAt = format(new Date(), "yyyy-MM-dd HH:mm:ss");

      const response = await fetch(`http://127.0.0.1:8000/api/task/${editingTask.id}`, {
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({
          title: editingTask.title,
          description: editingTask.description,
          category_id: editingTask.category_id,
          situacao_id: 2,
          finished_at: finishedAt
        })
      });

      if (!response.ok) throw new Error('Failed to update task');

      await fetchTasks(); // Recarrega as tarefas
      setIsEditing(false); // Encerra o modo de edição
      setEditingTask(null); // Limpa a tarefa em edição
      setFormData({ title: '', description: '', category_id: '', situacao_id: 2 }); // Reseta o formulário
      setShowForm(false); // Fecha o formulário
    } catch {
      setError('Failed to update task'); // Exibe mensagem de erro
    } finally {
      setIsLoading(false); // Desativa o loading
    }
  };


  // Delete task
  const handleDeleteTask = async (taskId: number) => {
    if (!window.confirm('Are you sure you want to delete this task?')) return;

    setIsLoading(true);
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/task/${taskId}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) throw new Error('Failed to delete task');

      await fetchTasks();
    } catch {
      setError('Failed to delete task');
    } finally {
      setIsLoading(false);
    }
  };

  const handleEdit = (task: Task) => {
    setIsEditing(true);
    setEditingTask(task);
    setFormData({
      title: task.title,
      description: task.description,
      category_id: task.category_id.toString(),
      situacao_id: task.situacao_id,
    });
    setShowForm(true);
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Mobile sidebar toggle */}
      <div className="lg:hidden fixed top-4 left-4 z-50">
        <button
          onClick={() => setIsSidebarOpen(!isSidebarOpen)}
          className="p-2 rounded-lg bg-white shadow-md text-gray-600 hover:text-gray-900"
        >
          {isSidebarOpen ? <X size={24} /> : <Menu size={24} />}
        </button>
      </div>

      {/* Sidebar */}
      <aside
        className={`fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
          } lg:translate-x-0`}
      >
        <div className="h-full flex flex-col">
          {/* Logo area */}
          <div className="p-6 border-b">
            <h1 className="text-2xl font-bold text-gray-900">Dashboard</h1>
          </div>

          {/* Navigation */}
          <nav className="flex-1 p-4 space-y-1">
            <button
              onClick={() => setActiveMenu('tasks')}
              className={`w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors ${activeMenu === 'tasks'
                ? 'bg-blue-50 text-blue-600'
                : 'text-gray-600 hover:bg-gray-50'
                }`}
            >
              <ListTodo size={20} />
              <span>Tasks</span>
            </button>

  
          </nav>

          {/* Logout button */}
          <div className="p-4 border-t">
            <button
              onClick={() => window.location.reload()}
              className="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors"
            >
              <LogOut size={20} />
              <span>Logout</span>
            </button>
          </div>
        </div>
      </aside>

      {/* Main content */}
      <main
        className={`min-h-screen transition-all duration-300 ${isSidebarOpen ? 'lg:ml-64' : ''
          }`}
      >
        <div className="p-8">
          {activeMenu === 'tasks' ? (
            <div className="space-y-6">
              <div className="flex justify-between items-center">
                <h2 className="text-2xl font-bold text-gray-900">Tasks</h2>

                <input
                  type="text"
                  placeholder="Pesquisar tarefas"
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-lg"
                />

                <button
                  onClick={() => {
                    setIsEditing(false);
                    setEditingTask(null);
                    setFormData({ title: '', description: '', category_id: '', situacao_id: 1 });
                    setShowForm(!showForm);
                  }}
                  className="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                  <Plus size={20} />
                  <span>New Task</span>
                </button>
              </div>

              {error && (
                <div className="bg-red-50 text-red-500 p-4 rounded-lg">
                  {error}
                </div>
              )}

              {showForm && (
                <div className="bg-white rounded-lg shadow p-6">
                  <form onSubmit={isEditing ? handleUpdateTask : handleCreateTask} className="space-y-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700">Title</label>
                      <input
                        type="text"
                        value={formData.title}
                        onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                        className="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700">Description</label>
                      <textarea
                        value={formData.description}
                        onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                        className="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        rows={3}
                        required
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700">Category</label>
                      <select
                        value={formData.category_id}
                        onChange={(e) => setFormData({ ...formData, category_id: e.target.value })}
                        className="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                      >
                        <option value="">Select a category</option>
                        {categories.map((category) => (
                          <option key={category.id} value={category.id}>
                            {category.name}
                          </option>
                        ))}
                      </select>
                    </div>
                    <div className="flex justify-end space-x-3">
                      <button
                        type="button"
                        onClick={() => {
                          setShowForm(false);
                          setIsEditing(false);
                          setEditingTask(null);
                        }}
                        className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                      >
                        Cancel
                      </button>
                      <button
                        type="submit"
                        disabled={isLoading}
                        className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                      >
                        {isLoading ? 'Saving...' : isEditing ? 'Update Task' : 'Create Task'}
                      </button>
                    </div>
                  </form>
                </div>
              )}
              <div className="bg-white rounded-lg shadow overflow-hidden">
                {isLoading && !tasks.length ? (

                  < div className="p-6 text-center text-gray-500">Loading tasks...</div>
                ) : tasks.length === 0 ? (
                  <div className="p-6 text-center text-gray-500">No tasks found</div>
                ) : (
                  <div className="divide-y divide-gray-200">
                    {filteredTasks.map((task) => (
                      <div key={task.id} className="p-6 flex items-start justify-between hover:bg-gray-50">
                        <div className="space-y-2">
                          <h3 className="text-lg font-medium text-gray-900">{task.title}</h3>
                          <p className="text-gray-600">{task.description}</p>
                          <p className="text-gray-600">
                            Data de início:{" "}
                            {formatDistance(new Date(task.created_at), new Date(), { addSuffix: true, locale: ptBR })}
                          </p>

                          <p className="text-gray-600">
                            {task.finished_at && (
                              <p className="text-gray-600">
                                Data de quando foi finalizado: {task.finished_at}
                              </p>
                            )}
                          </p>

                          <p className="text-sm text-gray-500">
                            Category: {categories.find((category) => category.id === task.category_id)?.name || "Categoria não encontrada"}
                          </p>

                          <p className="text-sm text-gray-800">
                            Situacao: {situacao.find((item) => item.id === task.situacao_id)?.name || "Situação não encontrada"}
                          </p>
                        </div>
                        <div className="flex space-x-2">
                          <button
                            onClick={() => handleEdit(task)}
                            className="p-2 text-gray-400 hover:text-blue-600"
                          >
                            <Pencil size={20} />
                          </button>
                          <button
                            onClick={() => handleDeleteTask(task.id)}
                            className="p-2 text-gray-400 hover:text-red-600"
                          >
                            <Trash2 size={20} />
                          </button>
                          <button
                            onClick={() => handleMarkCheckedTask(task)}
                            className="p-2 text-gray-400 hover:text-green-600"
                          >
                            <ShieldCheck size={20} />
                          </button>
                        </div>
                      </div>
                    ))}
                  </div>

                )}
              </div>
            </div>
          ) : (
            <div className="space-y-6">

            </div>
          )}
        </div>
      </main >
    </div >
  );
}

export default Dashboard;