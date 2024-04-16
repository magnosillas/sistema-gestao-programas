@extends('templates.app')

@section('body')
    @canany(['admin', 'servidor', 'pro_reitor', 'gestor'])

        <div class="container-fluid">
            @if (session('sucesso'))
                <div class="alert alert-success">
                    {{ session('sucesso') }}
                </div>
            @endif

            @if (session('falha'))
                <div class="alert alert-danger">
                    {{ session('falha') }}
                </div>
            @endif
            <br>


            <div style="display: flex; justify-content: space-evenly; align-items: center;">
                <h1 class="titulo"><strong>Editais</strong></h1>
            </div>


            <form class="search-container" action="{{ route('edital.index') }}" method="GET">
                <input class="search-input" onkeyup="" type="text" placeholder="Digite a busca" title=""
                       id="valor" name="valor" style="text-align: start">
                <input class="search-button" title="Fazer a pesquisa" type="submit" value=""></input>

                @if (auth()->user()->typage->tipo_servidor != 'pro_reitor')
                    <button class="cadastrar-botao" type="button"
                            onclick="window.location.href = '{{ route('edital.create') }}'">Cadastrar edital
                    </button>
                @endif

            </form>

            <br>
            <br>



            <div class="d-flex flex-wrap justify-content-center" style="flex-direction: row-reverse;">
                <div class="col-md-9 corpo p-2 px-3">
                    <table class="table">
                        <thead>
                        <tr class="table-head">
                            <th scope="col" class="text-center align-middle">Título</i></th>
                            <th scope="col" class="text-center align-middle">Data de início</th>
                            <th scope="col" class="text-center align-middle">Data de fim</th>
                            <th scope="col" class="text-center align-middle">Programa</th>
                            <th class="text-center">
                                Ações
                                <button type="button" class="infobutton align-bottom" data-bs-toggle="modal"
                                        data-bs-target="#modal_legenda" title="Ver legenda dos ícones">
                                    <img src="{{ asset('images/infolegenda.svg') }}" alt="Legenda"
                                         style="height: 20px; width: 20px;">
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($editais as $edital)
                            <tr>
                                <td class="align-middle">{{ $edital->titulo_edital }}</td>
                                <td class="align-middle">{{ date_format(date_create($edital->data_inicio), 'd/m/Y') }}</td>
                                <td class="align-middle">{{ date_format(date_create($edital->data_fim), 'd/m/Y') }}</td>
                                <td class="align-middle">{{ $edital->programa->nome }}</td>
                                <td>

                                    <a type="button" data-bs-toggle="modal"
                                       data-bs-target="#modal_show{{ $edital->id }}">
                                        <img src="{{ asset('images/information.svg') }}" title="Informações"
                                             alt="Info edital" style="height: 30px; width: 30px;">
                                    </a>

                                    @if (auth()->user()->typage->tipo_servidor != 'pro_reitor')
                                        <a type="button" href="{{ route('edital.show', ['id' => $edital->id]) }}">
                                            <img src="{{ asset('images/vincular_estudante.svg') }}"
                                                 title="Vincular estudante" alt="Vincular aluno"
                                                 style="height: 30px; width: 30px;">
                                        </a>
                                    @endif
                                    <a type="button" alt="Listar alunos"
                                       href="{{ route('edital.vinculo', ['id' => $edital->id]) }}">
                                        <img src="{{ asset('images/estudantes_vinculados.svg') }}"
                                             title="Listar estudantes vinculados" alt="Listar estudantes vinculados"
                                             style="height: 28px; width: 28px;">
                                    </a>
                                    @if (auth()->user()->typage->tipo_servidor != 'pro_reitor')
                                        <a type="button" alt="Listar alunos inativos"
                                           href="{{ route('edital.vinculoInativo', ['id' => $edital->id]) }}">
                                            <img src="{{ asset('images/estudantes_vinculados_inativos.svg') }}"
                                                 title="Listar estudantes vinculados inativos"
                                                 alt="Listar estudantes vinculados inativos"
                                                 style="height: 30px; width: 30px;">
                                        </a>
                                    @endif

                                    <a type="button" alt="Listar orientadores"
                                       href="{{ route('edital.listar_orientadores', ['id' => $edital->id]) }}">
                                        <img src="{{ asset('images/orientadores.svg') }}" title="Listar orientadores"
                                             alt="Listar orientadores" style="height: 30px; width: 30px;">
                                    </a>
                                    @if (auth()->user()->typage->tipo_servidor != 'pro_reitor' )
                                        <a type="button" href="{{ route('edital.edit', ['id' => $edital->id]) }}">
                                            <img src="{{ asset('images/pencil.svg') }}" title="Editar" alt="Editar edital"
                                                 style="height: 30px; width: 30px;">
                                        </a>

                                        <a type="button" data-bs-toggle="modal"
                                           data-bs-target="#modal_delete_{{ $edital->id }}">
                                            <img src="{{ asset('images/delete.svg') }}"title="Remover" alt="Deletar edital"
                                                 style="height: 30px; width: 30px;">
                                        </a>
                                    @endif
                                    @php
                                        // Criar uma instância de Carbon com a data final do edital
                                        $dataFinalEditalCarbon = \Carbon\Carbon::parse($edital->data_fim);

                                        // Verificar se a data final do edital está no passado
                                        $chegouDataFinalEdital = $dataFinalEditalCarbon->isPast();

                                    @endphp
                                    @if ($chegouDataFinalEdital)
                                        <a type="button" alt="Emitir certificados"
                                           href="{{ route('edital.emitir_certificados', ['edital_id' => $edital->id]) }}">
                                            <img src="{{ asset('images/listar_edital.svg') }}"
                                                 title="Emitir certificados dos estudantes vinculados"
                                                 alt="Emitir certificados dos estudantes vinculados"
                                                 style="height: 30px; width: 30px;">
                                        </a>

                                    @endif

                                </td>
                            </tr>
                        </tbody>
                        @include('Edital.components.modal_show', ['edital' => $edital])
                        @include('Edital.components.modal_delete', ['edital' => $edital])
                        @include('Edital.components.modal_legenda')
                        @endforeach
                    </table>
                </div>

            </div>
        </div>


        <script type="text/javascript">
            function exibirModalDeletar(id) {
                $('#modal_delete_' + id).modal('show');
            }

            function exibirModalVisualizar(id) {
                $('#modal_show' + id).modal('show');
            }
        </script>
    @else
        <h3 style="margin-top: 1rem">Você não possui permissão!</h3>
        <a class="btn btn-primary submit" style="margin-top: 1rem" href="{{ url('/login') }}">Voltar</a>
    @endcan
@endsection
