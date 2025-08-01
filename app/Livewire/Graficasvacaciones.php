<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SolicitudVacaciones;
use Carbon\Carbon;

class GraficasVacaciones extends Component
{
    public $labels = [];
    public $data = [];
    public $filtro = 'anio';

    public function mount()
    {
        $this->actualizarDatos();
    }

    public function updatedFiltro()
    {
        $this->actualizarDatos();
    }

    public function obtenerRango()
    {
        $hoy = Carbon::today();

        return match ($this->filtro) {
            'hoy' => [$hoy, $hoy],
            'semana' => [$hoy->copy()->startOfWeek(), $hoy->copy()->endOfWeek()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'anio' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
            default => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        };
    }

    public function actualizarDatos()
    {
        [$inicio, $fin] = $this->obtenerRango();

        $this->labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $vacaciones = SolicitudVacaciones::where('estatus', 'Aceptada')
            ->whereBetween('fecha_inicio', [$inicio, $fin])
            ->selectRaw('MONTH(fecha_inicio) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->pluck('total', 'mes');

        $this->data = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $this->data[] = $vacaciones->get($mes, 0);
        }

        $this->dispatch('chart-vacaciones-updated', data: $this->data);
    }

    public function render()
    {
        return view('livewire.graficas-vacaciones', [
            'filtro' => $this->filtro,
        ]);
    }
}
