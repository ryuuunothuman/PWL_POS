<?php

namespace App\DataTables;

use App\Models\m_user;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class m_userDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($m_user) {
                return
                    '<div class="d-flex px-3 gap-2">
                         <form action="' . route('m_user.edit', $m_user['user_id']) . '" method="GET">
                             <button type="submit" class="btn btn-sm btn-success">Edit</button>
                         </form>
                         <form action="' . route('m_user.show', $m_user['user_id']) . '" method="GET">
                             <button type="submit" class="btn btn-sm btn-dark">Show</button>
                         </form>
                         <form action="' . route('m_user.destroy', $m_user['user_id']) . '" method="POST">
                             '.csrf_field().'
                             '.method_field('DELETE').'
                             <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                         </form>
                    </div>'
                ;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }



    /**
     * Get the query source of dataTable.
     */
    public function query(m_user $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('m_user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user_id'),
            Column::make('level_id'),
            Column::make('username'),
            Column::make('nama'),
            Column::make('password'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'
            ),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'm_user_' . date('YmdHis');
    }
}