<?php

namespace Hcode\Model;

use Hcode\DB\sql;
use Hcode\Model;

class Category extends Model
{
    public static function listAll()
    {
        $sql = new Sql();

        return $sql->select('SELECT * FROM tb_categories ORDER BY descategory');
    }

    public function save()
    {
        $sql = new Sql();

        $results = $sql->select('CALL sp_categories_save(:idcategory, :descategory)', [
         ':idcategory' => $this->getidcategory(),
         ':descategory' => $this->getdescategory(),
        ]);

        Category::updateFile();

        $this->setData($results[0]);
    }

    public function get($idcategory)
    {
        $sql = new Sql();

        $results = $sql->select('SELECT * FROM tb_categories WHERE idcategory =:idcategory', [
            ':idcategory' => $idcategory,
        ]);

        $this->setData($results[0]);
    }

    public function delete()
    {
        $sql = new Sql();
        $sql->query('DELETE FROM tb_categories WHERE idcategory =:idcategory', [
            ':idcategory' => $this->getidcategory(),
        ]);

        Category::updateFile();
    }

    /**
     * Atualiza o arquivo de categorias.
     *
     * @return void
     */
    public function updateFile()
    {
        $categories = Category::listAll();
        $html = [];
        foreach ($categories as $category) {
            array_push($html, '<li><a href="/categories/'.$category['idcategory'].'">'.$category['descategory'].'</a></li>');
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'categories-menu.html', implode('', $html));
    }
}
