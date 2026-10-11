<?php

namespace Tests\Feature\Models;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function crea_un_usuario_con_todos_los_campos_requeridos(): void
    {
        $user = User::factory()->create([
            'name' => 'Yeritzon',
            'last_name' => 'Salinas',
            'document_number' => '118820456',
            'email' => 'yeritzon@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Yeritzon',
            'last_name' => 'Salinas',
            'document_number' => '118820456',
            'email' => 'yeritzon@example.com',
        ]);
    }

    #[Test]
    public function el_estado_por_defecto_es_inactivo(): void
    {
        $this->assertSame(UserStatus::Inactivo, User::factory()->create()->status);
    }

    #[Test]
    public function la_factory_expone_los_tres_estados(): void
    {
        $this->assertSame(UserStatus::Activo, User::factory()->activo()->create()->status);
        $this->assertSame(UserStatus::Inactivo, User::factory()->inactivo()->create()->status);
        $this->assertSame(UserStatus::Suspendido, User::factory()->suspendido()->create()->status);
    }

    #[Test]
    public function el_correo_no_se_puede_repetir(): void
    {
        User::factory()->create(['email' => 'repetido@example.com']);

        $this->expectException(QueryException::class);

        User::factory()->create(['email' => 'repetido@example.com']);
    }

    #[Test]
    public function el_numero_de_documento_no_se_puede_repetir(): void
    {
        User::factory()->create(['document_number' => '118820456']);

        $this->expectException(QueryException::class);

        User::factory()->create(['document_number' => '118820456']);
    }

    #[Test]
    public function el_borrado_es_logico_y_no_physical(): void
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
        $this->assertNull(User::find($user->id));
        $this->assertNotNull(User::withTrashed()->find($user->id));
    }

    #[Test]
    public function oculta_el_password_y_el_remember_token_al_serializar(): void
    {
        $user = User::factory()->create();

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
        $this->assertArrayHasKey('email', $array);
    }

    #[Test]
    public function convierte_las_fechas_en_objetos_de_fecha_hora(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->last_login_at);
    }

    #[Test]
    public function el_password_se_guarda_cifrado(): void
    {
        $user = User::factory()->create(['password' => 'clave-secreta']);

        $this->assertNotSame('clave-secreta', $user->getAuthPassword());
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('clave-secreta', $user->getAuthPassword()));
    }
}