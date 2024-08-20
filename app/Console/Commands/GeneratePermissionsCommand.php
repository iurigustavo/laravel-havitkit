<?php

namespace App\Console\Commands;

use ReflectionClass;
use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GeneratePermissionsCommand extends Command
{
    protected $signature = 'generate:permissions';

    protected $description = 'Command description';

    public function handle(): void
    {
        foreach ($this->listModels() as $model) {
            $modelName = Str::of($model)->afterLast('\\')->toString();
            $singular = Str::of($modelName)->lower()->toString();
            $plural = Str::of($modelName)->plural()->lower()->toString();

            $permissions = [
                'list' => 'Can list '.$plural,
                'view' => 'Can view '.$singular,
                'create' => 'Can create '.$plural,
                'update' => 'Can update '.$singular,
                'delete' => 'Can delete '.$singular,
                'restore' => 'Can restore '.$singular,
                'forceDelete' => 'Can permanently delete '.$singular,
            ];

            foreach ($permissions as $permission => $description) {
                Permission::firstOrCreate(
                    [
                        'name' => $permission.' '.$singular,
                        'guard_name' => 'web',
                    ],
                    [
                        'description' => $description,
                    ]
                );
            }

            $this->call('make:policy', ['--model' => $model, 'name' => $modelName.'Policy']);
        }
    }

    private function listModels()
    {
        $models = collect(File::allFiles(app_path('Models')))
            ->map(fn ($item): ?string => $this->getClassFromFile($item, $item->getRelativePathName()))
            ->filter(function ($class): bool {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        ! $reflection->isAbstract();
                }

                return $valid;
            });

        return $models->values();
    }

    protected function getClassFromFile($file, $relativePath): ?string
    {
        $contents = file_get_contents($file->getPathname());
        if (preg_match('/namespace\s+([^;]+);/', $contents, $matches)) {
            $namespace = $matches[1];
            $className = strtr(substr((string) $relativePath, 0, strrpos((string) $relativePath, '.')), '/', '\\');

            return $namespace.'\\'.class_basename($className);
        }

        return null;
    }
}
