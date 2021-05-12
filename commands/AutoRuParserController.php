<?php

namespace app\commands;

use app\component\Parser\AutoRu\Interfaces\AutoParserServiceInterface;
use app\models\CarBody;
use app\models\CarFuel;
use app\models\CarGeneration;
use app\models\Mark;
use app\models\MarkModel;
use app\models\ModelModification;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class AutoRuParserController
 */
class AutoRuParserController extends Controller
{
    private $parser;
    
    public function __construct($id, $module, AutoParserServiceInterface $parser, $config = [])
    {
        $this->parser = $parser;
        
        parent::__construct($id, $module, $config);
    }
    
    /**
     * @return int Exit code
     */
    public function actionParse()
    {
        $data = $this->parser->execute();
        /**
         * [
         * 'mark'      => $this->getMark($matches['mark']),
         * 'model'     => $this->getModel($matches['mark']),
         * 'pokolenie' => $matches['pokolenie'],
         * 'body'      => $matches['body'],
         * 'fuel'      => $matches['fuel'],
         * 'modif'     => $matches['modif'],
         * ]
         */
        foreach ($data as $item) {
            try {
                $tr = \Yii::$app->db->beginTransaction();
                
                $mark = $this->createMark($item['mark']);
                $model = $this->createModel($item['model'], $mark);
                $modif = $this->createModif($model, $item['modif'], $item['body'], $item['fuel'], $item['pokolenie']);
                echo 'Создано: марка: ' . $mark->name . ' ' . $model->name . ' ' . $modif->name . ' ' . $modif->body . ' ' . $modif->fuel . ' ' . $modif->tKppType . PHP_EOL;
                $tr->commit();
            } catch (\Exception $exception) {
                $tr->rollback();
                
                echo 'Error: ' . $exception->getMessage();
            }
        }
        
        return ExitCode::OK;
    }
    
    private function createMark(string $mark)
    {
        $mark = Mark::findOne(['name' => $mark]) ?? new Mark(
                [
                    'name' => $mark,
                ]
            );
        $mark->save();
        
        return $mark;
    }
    
    private function createModel(string $model, Mark $mark)
    {
        $markModel = MarkModel::findOne(
                [
                    'name'    => $model,
                    'mark_id' => $mark->id,
                ]
            ) ??
            new MarkModel(
                [
                    'name'    => $model,
                    'mark_id' => $mark->id,
                ]
            );
        if ($markModel->isNewRecord) {
            $markModel->save();
        }
        
        return $markModel;
    }
    
    private function createPokolenie(MarkModel $model, $pokolenie)
    {
        $pokolenie = CarGeneration::findOne(
                [
                    'name'     => $pokolenie,
                    'mark_id'  => $model->mark_id,
                    'model_id' => $model->id,
                ]
            ) ?? new CarGeneration(
                [
                    'name'     => $pokolenie,
                    'mark_id'  => $model->mark_id,
                    'model_id' => $model->id,
                ]
            );
        $pokolenie->save();
        
        return $pokolenie;
    }
    
    private function createBody(MarkModel $model, CarGeneration $pokolenie, string $body)
    {
        $modelBody = CarBody::findOne(
                [
                    'name'     => $body,
                    'mark_id'  => $model->mark_id,
                    'model_id' => $model->id,
                ]
            ) ?? new CarBody(
                [
                    'name'     => $body,
                    'mark_id'  => $model->mark_id,
                    'model_id' => $model->id,
                ]
            );
        
        $modelBody->save();
        
        return $modelBody;
    }
    
    private function createFuel(MarkModel $model, $fuel)
    {
        $modelFuel = CarFuel::findOne(
                [
                    'name'     => $fuel,
                    'mark_id'  => $model->mark_id,
                    'model_id' => $model->id,
                ]
            ) ?? new CarFuel(
                [
                    'name'     => $fuel,
                    'mark_id'  => $model->mark_id,
                    'model_id' => $model->id,
                ]
            );
        
        $modelFuel->save();
        
        return $modelFuel;
    }
    
    private function createModif(MarkModel $model, $modif, $body, $fuel, $pokolenie)
    {
        $modelModif = ModelModification::findOne(
                [
                    'name'            => $modif,
                    'mark_id'         => $model->mark_id,
                    'model_id'        => $model->id,
                    'body'            => $body,
                    'generation_name' => $pokolenie,
                    'fuel'            => $fuel,
                    'tKppType'        => $this->getKppType($modif),
                ]
            ) ?? new ModelModification(
                [
                    'name'            => $modif,
                    'mark_id'         => $model->mark_id,
                    'model_id'        => $model->id,
                    'body'            => $body,
                    'generation_name' => $pokolenie,
                    'fuel'            => $fuel,
                    'tKppType'        => $this->getKppType($modif),
                ]
            );
        
        $modelModif->save();
        
        return $modelModif;
    }
    
    private function getKppType($str): string
    {
        $explode = explode(' ', $str);
        
        return $explode[1] ?? '';
    }
}
