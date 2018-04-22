<?php
/**
 * This is the template for generating the crud operations unit test class of a specified model.
 * DO NOT EDIT THIS FILE! It may be regenerated with Gii.
 *
 * @var yii\web\View
 * @var schmunk42\giiant\generators\model\Generator $generator
 * @var string                                      $className class name
 * @var array                                       $relations list of relations (name => relation declaration)
 * @var string[]                                    $labels list of attribute labels (name => label)
 * @var string[]                                    $rules list of validation rules
 * @var array[]                                     $attributes list of attributes with labels and types
 * @var string                                      $modelClass fully qualified model class name
 * @var string                                      $controllerClass fully qualified controller class name
 */
echo "<?php\n";
?>
namespace tests\codeception\backend\unit\models;

use Yii;
use tests\codeception\backend\unit\DbTestCase;
use Codeception\Specify;
use <?= $modelClass ?>;
use yii\faker;
use schmunk42\giiant\helpers\GiiantFaker;

class <?= $className ?>Test extends DbTestCase
{
    use Specify;

    private $class = '<?= $modelClass ?>';
    private $modelName = '<?= $className ?>';
    private $modelPK = null;
    private $isModelValidationEnabled = true;
    const ERROR_SAVE_VALIDATION = "Model was not saved. Please check its validation rules.";

    /**
    * Clears DB data after each test case
    */
    protected function tearDown()
    {
        if($this->modelPK != null){
            $cls = $this->class;
            $model = $cls::findOne($this->modelPK);
            if($model){
                $model->delete();
            }
        }
    }

    #region TESTS

    /**
    * Tests if model can be created and properties set
    */
    public function testModelCreate()
    {
        $model = $this->newModelInstance();
        $this->specify($this->modelName.' model should be created', function () use ($model) {
<?php foreach ($attributes as $attr):
        if (isPK($attr)) {
            continue;
        }?>
            expect('model\'s attribute "<?= $attr['label'] ?>" exists ', isset($model-><?= $attr['name'] ?>))->true();
<?php endforeach; ?>
        });
    }

    /**
    * Tests if model can be saved to DB
    */
    public function testModelSave()
    {
        $model = $this->newModelInstance();
        if(!$model->save($this->isModelValidationEnabled)){
            $this->fail(self::ERROR_SAVE_VALIDATION);
        }
        $this->modelPK = $model-><?php echo PKAttributeName($attributes); ?>;

        $reloadedModel = $this->loadModelById($this->modelPK);

        $this->specify($this->modelName.' model should be saved', function () use ($reloadedModel, $model) {
<?php foreach ($attributes as $attr):
        if (isPK($attr)) {
            continue;
        }?>
            expect('model\'s attribute "<?= $attr['label'] ?>" saved correctly', $reloadedModel-><?= $attr['name'] ?>)->equals($model-><?= $attr['name'] ?>);
<?php endforeach; ?>
        });
        $this->assertNotEmpty($model-><?php echo PKAttributeName($attributes); ?>);
    }

    /**
     * Tests if model from DB can be updated
     */
    public function testModelUpdate()
    {
        $originalModel = $this->newModelInstance();
        if(!$originalModel->save($this->isModelValidationEnabled)){
            $this->fail(self::ERROR_SAVE_VALIDATION);
        }
        $this->modelPK = $originalModel-><?php echo PKAttributeName($attributes); ?>;

        $updatedModel = clone $originalModel;

<?php foreach ($attributes as $attr):
    if (isPK($attr)) {
        continue;
    }?>
        $updatedModel-><?php echo $attr['name'] ?> = $this->updateAttributeValue($originalModel-><?php echo $attr['name'] ?>, '<?php echo $attr['name'] ?>', '<?php echo $attr['type'] ?>');
<?php endforeach; ?>
        if(!$updatedModel->save($this->isModelValidationEnabled)){
            $this->fail(self::ERROR_SAVE_VALIDATION);
        }
        $reloadedModel = $this->loadModelById($this->modelPK);

        $this->specify($this->modelName.' model should be updated', function () use ($reloadedModel, $updatedModel) {
<?php foreach ($attributes as $attr): ?>
            expect('model\'s attribute "<?= $attr['label'] ?>" was updated ', $reloadedModel-><?= $attr['name'] ?>)->equals($updatedModel-><?= $attr['name'] ?>);
<?php endforeach; ?>
        });
    }


    /**
     * Tests if model in DB can be deleted
     */
    public function testModelDelete()
    {
        $model = $this->newModelInstance();
        if(!$model->save($this->isModelValidationEnabled)){
            $this->fail(self::ERROR_SAVE_VALIDATION);
        }
        $this->modelPK = $model-><?php echo PKAttributeName($attributes); ?>;
        $model = $this->loadModelById($this->modelPK);
        $model->delete();
        $deletedModel = $this->loadModelById($this->modelPK);
        $this->specify($this->modelName.' model should be deleted', function () use ($deletedModel) {
            expect($this->modelName.' model was deleted', $deletedModel)->equals(null);
        });
    }

    #endregion


    #region PRIVATE METHODS


    /**
     * Creates new model instance
     *
     * @return new instance of model
     */
    private function newModelInstance()
    {
        $r = new \ReflectionClass($this->class);
        $model = $r->newInstance();
<?php foreach ($attributes as $attr):
    if (isPK($attr)) {
        continue;
    }?>
        $model-><?php echo $attr['name'] ?> = GiiantFaker::<?php echo $attr['type'] ?>('<?php echo $attr['name'] ?>');
<?php endforeach; ?>

        return $model;
    }

    /**
     * Returns model from DB by ID
     *
     * @param $id
     * @return null|static
     */
    private function loadModelById($id)
    {
        $r = new \ReflectionClass($this->class);
        return $r->getMethod("findOne")->invokeArgs(null, [$id]);
    }

    /**
    * Returns new value of provided type and makes sure that it's different from old value
    *
    * @param $olgoodmalllue previously used value
    * @param $attributeName model's attribute name
    * @param $attributeType model's attribute type
    * @return mixed
    */
    private function updateAttributeValue($olgoodmalllue, $attributeName, $attributeType){
        $newValue = $olgoodmalllue;
        while($newValue === $olgoodmalllue){
            $newValue = GiiantFaker::value($attributeType, $attributeName);
        }
        return $newValue;
    }

    #endregion

}
<?php

//region HELPER FUNCTIONS

function isPK($attribute)
{
    return $attribute['primary'] === true;
}

function PKAttributeName($attributes)
{
    foreach ($attributes as $a):
        if ($a['primary'] === true) {
            return $a['name'];
        }
    endforeach;

    return 'id';
}

#endregions
