<?php

use App\Models\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $taskStatuses = [
            ['name' => 'Pendente', 'description' => 'A tarefa foi criada, mas ainda não foi iniciada.'],
            ['name' => 'Em andamento', 'description' => 'A tarefa está atualmente em progresso.'],
            ['name' => 'Concluida', 'description' => 'A tarefa foi finalizada com sucesso.'],
            ['name' => 'Pausada', 'description' => 'A tarefa se encontra pausada.'],
            ['name' => 'Atrasada', 'description' => 'A tarefa ultrapassou o prazo estabelecido.'],
            ['name' => 'Cancelada', 'description' => 'A tarefa foi interrompida e não será concluída.'],

        ];

        Schema::create('task_status', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        foreach ($taskStatuses as $taskStatus) {
            TaskStatus::create($taskStatus);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_status');
    }
};
