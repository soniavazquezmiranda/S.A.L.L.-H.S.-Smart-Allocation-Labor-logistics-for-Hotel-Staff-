@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 py-8">
        
        <div class="bg-slate-900 rounded-2xl p-8 text-white text-center">
            <h1 class="text-2xl font-bold">S.A.L.L. HOTEL SYSTEM</h1>
            <p class="text-xs text-amber-400 mt-1 uppercase tracking-widest font-semibold">Entorno Base — Rama Develop</p>
            <p class="text-sm text-slate-300 mt-3">
                Selecciona un módulo para verificar que su vista base y controlador cargan correctamente.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <a href="{{ route('recepcion.index') }}" class="p-4 bg-white rounded-xl border border-slate-200 hover:border-slate-400 font-semibold text-slate-800">
                Ir a Recepción →
            </a>
            <a href="{{ route('gobernanta.index') }}" class="p-4 bg-white rounded-xl border border-slate-200 hover:border-slate-400 font-semibold text-slate-800">
                Ir a Gobernanta →
            </a>
            <a href="{{ route('comercial.index') }}" class="p-4 bg-white rounded-xl border border-slate-200 hover:border-slate-400 font-semibold text-slate-800">
                Ir a Comercial →
            </a>
            <a href="{{ route('pda.index') }}" class="p-4 bg-white rounded-xl border border-slate-200 hover:border-slate-400 font-semibold text-slate-800">
                Ir a Terminal PDA →
            </a>
        </div>

    </div>
@endsection