<?php

namespace Base;

use \ApprovedUser as ChildApprovedUser;
use \ApprovedUserQuery as ChildApprovedUserQuery;
use \Branch as ChildBranch;
use \BranchQuery as ChildBranchQuery;
use \Budget as ChildBudget;
use \BudgetQuery as ChildBudgetQuery;
use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \PurchasingAgent as ChildPurchasingAgent;
use \PurchasingAgentQuery as ChildPurchasingAgentQuery;
use \Supervisor as ChildSupervisor;
use \SupervisorQuery as ChildSupervisorQuery;
use \Exception;
use \PDO;
use Map\ApprovedUserTableMap;
use Map\BranchTableMap;
use Map\BudgetTableMap;
use Map\PurchasingAgentTableMap;
use Map\SupervisorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'branch' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Branch implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\BranchTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the location_id field.
     *
     * @var        int
     */
    protected $location_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * @var        ChildLocation
     */
    protected $aLocation;

    /**
     * @var        ObjectCollection|ChildApprovedUser[] Collection to store aggregation of ChildApprovedUser objects.
     */
    protected $collApprovedUsers;
    protected $collApprovedUsersPartial;

    /**
     * @var        ObjectCollection|ChildBudget[] Collection to store aggregation of ChildBudget objects.
     */
    protected $collBudgets;
    protected $collBudgetsPartial;

    /**
     * @var        ObjectCollection|ChildPurchasingAgent[] Collection to store aggregation of ChildPurchasingAgent objects.
     */
    protected $collPurchasingAgents;
    protected $collPurchasingAgentsPartial;

    /**
     * @var        ObjectCollection|ChildSupervisor[] Collection to store aggregation of ChildSupervisor objects.
     */
    protected $collSupervisors;
    protected $collSupervisorsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildApprovedUser[]
     */
    protected $approvedUsersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBudget[]
     */
    protected $budgetsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPurchasingAgent[]
     */
    protected $purchasingAgentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSupervisor[]
     */
    protected $supervisorsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Branch object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Branch</code> instance.  If
     * <code>obj</code> is an instance of <code>Branch</code>, delegates to
     * <code>equals(Branch)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Branch The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [location_id] column value.
     *
     * @return int
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BranchTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [location_id] column.
     *
     * @param int $v new value
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function setLocationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->location_id !== $v) {
            $this->location_id = $v;
            $this->modifiedColumns[BranchTableMap::COL_LOCATION_ID] = true;
        }

        if ($this->aLocation !== null && $this->aLocation->getId() !== $v) {
            $this->aLocation = null;
        }

        return $this;
    } // setLocationId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[BranchTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BranchTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BranchTableMap::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->location_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BranchTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = BranchTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Branch'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aLocation !== null && $this->location_id !== $this->aLocation->getId()) {
            $this->aLocation = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BranchTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBranchQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aLocation = null;
            $this->collApprovedUsers = null;

            $this->collBudgets = null;

            $this->collPurchasingAgents = null;

            $this->collSupervisors = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Branch::setDeleted()
     * @see Branch::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BranchTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBranchQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BranchTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                BranchTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aLocation !== null) {
                if ($this->aLocation->isModified() || $this->aLocation->isNew()) {
                    $affectedRows += $this->aLocation->save($con);
                }
                $this->setLocation($this->aLocation);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->approvedUsersScheduledForDeletion !== null) {
                if (!$this->approvedUsersScheduledForDeletion->isEmpty()) {
                    \ApprovedUserQuery::create()
                        ->filterByPrimaryKeys($this->approvedUsersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->approvedUsersScheduledForDeletion = null;
                }
            }

            if ($this->collApprovedUsers !== null) {
                foreach ($this->collApprovedUsers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->budgetsScheduledForDeletion !== null) {
                if (!$this->budgetsScheduledForDeletion->isEmpty()) {
                    foreach ($this->budgetsScheduledForDeletion as $budget) {
                        // need to save related object because we set the relation to null
                        $budget->save($con);
                    }
                    $this->budgetsScheduledForDeletion = null;
                }
            }

            if ($this->collBudgets !== null) {
                foreach ($this->collBudgets as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->purchasingAgentsScheduledForDeletion !== null) {
                if (!$this->purchasingAgentsScheduledForDeletion->isEmpty()) {
                    \PurchasingAgentQuery::create()
                        ->filterByPrimaryKeys($this->purchasingAgentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->purchasingAgentsScheduledForDeletion = null;
                }
            }

            if ($this->collPurchasingAgents !== null) {
                foreach ($this->collPurchasingAgents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->supervisorsScheduledForDeletion !== null) {
                if (!$this->supervisorsScheduledForDeletion->isEmpty()) {
                    \SupervisorQuery::create()
                        ->filterByPrimaryKeys($this->supervisorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->supervisorsScheduledForDeletion = null;
                }
            }

            if ($this->collSupervisors !== null) {
                foreach ($this->collSupervisors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[BranchTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BranchTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BranchTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(BranchTableMap::COL_LOCATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'location_id';
        }
        if ($this->isColumnModified(BranchTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO branch (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'location_id':
                        $stmt->bindValue($identifier, $this->location_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BranchTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getLocationId();
                break;
            case 2:
                return $this->getName();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Branch'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Branch'][$this->hashCode()] = true;
        $keys = BranchTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLocationId(),
            $keys[2] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aLocation) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'location';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'location';
                        break;
                    default:
                        $key = 'Location';
                }

                $result[$key] = $this->aLocation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collApprovedUsers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'approvedUsers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'approved_users';
                        break;
                    default:
                        $key = 'ApprovedUsers';
                }

                $result[$key] = $this->collApprovedUsers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBudgets) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'budgets';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'budgets';
                        break;
                    default:
                        $key = 'Budgets';
                }

                $result[$key] = $this->collBudgets->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPurchasingAgents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'purchasingAgents';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'purchasing_agents';
                        break;
                    default:
                        $key = 'PurchasingAgents';
                }

                $result[$key] = $this->collPurchasingAgents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSupervisors) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'supervisors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'supervisors';
                        break;
                    default:
                        $key = 'Supervisors';
                }

                $result[$key] = $this->collSupervisors->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Branch
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BranchTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Branch
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLocationId($value);
                break;
            case 2:
                $this->setName($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = BranchTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocationId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Branch The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BranchTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BranchTableMap::COL_ID)) {
            $criteria->add(BranchTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BranchTableMap::COL_LOCATION_ID)) {
            $criteria->add(BranchTableMap::COL_LOCATION_ID, $this->location_id);
        }
        if ($this->isColumnModified(BranchTableMap::COL_NAME)) {
            $criteria->add(BranchTableMap::COL_NAME, $this->name);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildBranchQuery::create();
        $criteria->add(BranchTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Branch (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLocationId($this->getLocationId());
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getApprovedUsers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApprovedUser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBudgets() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBudget($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPurchasingAgents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPurchasingAgent($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSupervisors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSupervisor($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Branch Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildLocation object.
     *
     * @param  ChildLocation $v
     * @return $this|\Branch The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLocation(ChildLocation $v = null)
    {
        if ($v === null) {
            $this->setLocationId(NULL);
        } else {
            $this->setLocationId($v->getId());
        }

        $this->aLocation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLocation object, it will not be re-added.
        if ($v !== null) {
            $v->addBranch($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildLocation object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildLocation The associated ChildLocation object.
     * @throws PropelException
     */
    public function getLocation(ConnectionInterface $con = null)
    {
        if ($this->aLocation === null && ($this->location_id !== null)) {
            $this->aLocation = ChildLocationQuery::create()->findPk($this->location_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLocation->addBranches($this);
             */
        }

        return $this->aLocation;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ApprovedUser' == $relationName) {
            return $this->initApprovedUsers();
        }
        if ('Budget' == $relationName) {
            return $this->initBudgets();
        }
        if ('PurchasingAgent' == $relationName) {
            return $this->initPurchasingAgents();
        }
        if ('Supervisor' == $relationName) {
            return $this->initSupervisors();
        }
    }

    /**
     * Clears out the collApprovedUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addApprovedUsers()
     */
    public function clearApprovedUsers()
    {
        $this->collApprovedUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collApprovedUsers collection loaded partially.
     */
    public function resetPartialApprovedUsers($v = true)
    {
        $this->collApprovedUsersPartial = $v;
    }

    /**
     * Initializes the collApprovedUsers collection.
     *
     * By default this just sets the collApprovedUsers collection to an empty array (like clearcollApprovedUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApprovedUsers($overrideExisting = true)
    {
        if (null !== $this->collApprovedUsers && !$overrideExisting) {
            return;
        }

        $collectionClassName = ApprovedUserTableMap::getTableMap()->getCollectionClassName();

        $this->collApprovedUsers = new $collectionClassName;
        $this->collApprovedUsers->setModel('\ApprovedUser');
    }

    /**
     * Gets an array of ChildApprovedUser objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBranch is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildApprovedUser[] List of ChildApprovedUser objects
     * @throws PropelException
     */
    public function getApprovedUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collApprovedUsersPartial && !$this->isNew();
        if (null === $this->collApprovedUsers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApprovedUsers) {
                // return empty collection
                $this->initApprovedUsers();
            } else {
                $collApprovedUsers = ChildApprovedUserQuery::create(null, $criteria)
                    ->filterByBranch($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collApprovedUsersPartial && count($collApprovedUsers)) {
                        $this->initApprovedUsers(false);

                        foreach ($collApprovedUsers as $obj) {
                            if (false == $this->collApprovedUsers->contains($obj)) {
                                $this->collApprovedUsers->append($obj);
                            }
                        }

                        $this->collApprovedUsersPartial = true;
                    }

                    return $collApprovedUsers;
                }

                if ($partial && $this->collApprovedUsers) {
                    foreach ($this->collApprovedUsers as $obj) {
                        if ($obj->isNew()) {
                            $collApprovedUsers[] = $obj;
                        }
                    }
                }

                $this->collApprovedUsers = $collApprovedUsers;
                $this->collApprovedUsersPartial = false;
            }
        }

        return $this->collApprovedUsers;
    }

    /**
     * Sets a collection of ChildApprovedUser objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $approvedUsers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function setApprovedUsers(Collection $approvedUsers, ConnectionInterface $con = null)
    {
        /** @var ChildApprovedUser[] $approvedUsersToDelete */
        $approvedUsersToDelete = $this->getApprovedUsers(new Criteria(), $con)->diff($approvedUsers);


        $this->approvedUsersScheduledForDeletion = $approvedUsersToDelete;

        foreach ($approvedUsersToDelete as $approvedUserRemoved) {
            $approvedUserRemoved->setBranch(null);
        }

        $this->collApprovedUsers = null;
        foreach ($approvedUsers as $approvedUser) {
            $this->addApprovedUser($approvedUser);
        }

        $this->collApprovedUsers = $approvedUsers;
        $this->collApprovedUsersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ApprovedUser objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ApprovedUser objects.
     * @throws PropelException
     */
    public function countApprovedUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collApprovedUsersPartial && !$this->isNew();
        if (null === $this->collApprovedUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApprovedUsers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApprovedUsers());
            }

            $query = ChildApprovedUserQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBranch($this)
                ->count($con);
        }

        return count($this->collApprovedUsers);
    }

    /**
     * Method called to associate a ChildApprovedUser object to this object
     * through the ChildApprovedUser foreign key attribute.
     *
     * @param  ChildApprovedUser $l ChildApprovedUser
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function addApprovedUser(ChildApprovedUser $l)
    {
        if ($this->collApprovedUsers === null) {
            $this->initApprovedUsers();
            $this->collApprovedUsersPartial = true;
        }

        if (!$this->collApprovedUsers->contains($l)) {
            $this->doAddApprovedUser($l);

            if ($this->approvedUsersScheduledForDeletion and $this->approvedUsersScheduledForDeletion->contains($l)) {
                $this->approvedUsersScheduledForDeletion->remove($this->approvedUsersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildApprovedUser $approvedUser The ChildApprovedUser object to add.
     */
    protected function doAddApprovedUser(ChildApprovedUser $approvedUser)
    {
        $this->collApprovedUsers[]= $approvedUser;
        $approvedUser->setBranch($this);
    }

    /**
     * @param  ChildApprovedUser $approvedUser The ChildApprovedUser object to remove.
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function removeApprovedUser(ChildApprovedUser $approvedUser)
    {
        if ($this->getApprovedUsers()->contains($approvedUser)) {
            $pos = $this->collApprovedUsers->search($approvedUser);
            $this->collApprovedUsers->remove($pos);
            if (null === $this->approvedUsersScheduledForDeletion) {
                $this->approvedUsersScheduledForDeletion = clone $this->collApprovedUsers;
                $this->approvedUsersScheduledForDeletion->clear();
            }
            $this->approvedUsersScheduledForDeletion[]= clone $approvedUser;
            $approvedUser->setBranch(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Branch is new, it will return
     * an empty collection; or if this Branch has previously
     * been saved, it will retrieve related ApprovedUsers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Branch.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApprovedUser[] List of ChildApprovedUser objects
     */
    public function getApprovedUsersJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApprovedUserQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getApprovedUsers($query, $con);
    }

    /**
     * Clears out the collBudgets collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBudgets()
     */
    public function clearBudgets()
    {
        $this->collBudgets = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBudgets collection loaded partially.
     */
    public function resetPartialBudgets($v = true)
    {
        $this->collBudgetsPartial = $v;
    }

    /**
     * Initializes the collBudgets collection.
     *
     * By default this just sets the collBudgets collection to an empty array (like clearcollBudgets());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBudgets($overrideExisting = true)
    {
        if (null !== $this->collBudgets && !$overrideExisting) {
            return;
        }

        $collectionClassName = BudgetTableMap::getTableMap()->getCollectionClassName();

        $this->collBudgets = new $collectionClassName;
        $this->collBudgets->setModel('\Budget');
    }

    /**
     * Gets an array of ChildBudget objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBranch is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBudget[] List of ChildBudget objects
     * @throws PropelException
     */
    public function getBudgets(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBudgetsPartial && !$this->isNew();
        if (null === $this->collBudgets || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBudgets) {
                // return empty collection
                $this->initBudgets();
            } else {
                $collBudgets = ChildBudgetQuery::create(null, $criteria)
                    ->filterByBranch($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBudgetsPartial && count($collBudgets)) {
                        $this->initBudgets(false);

                        foreach ($collBudgets as $obj) {
                            if (false == $this->collBudgets->contains($obj)) {
                                $this->collBudgets->append($obj);
                            }
                        }

                        $this->collBudgetsPartial = true;
                    }

                    return $collBudgets;
                }

                if ($partial && $this->collBudgets) {
                    foreach ($this->collBudgets as $obj) {
                        if ($obj->isNew()) {
                            $collBudgets[] = $obj;
                        }
                    }
                }

                $this->collBudgets = $collBudgets;
                $this->collBudgetsPartial = false;
            }
        }

        return $this->collBudgets;
    }

    /**
     * Sets a collection of ChildBudget objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $budgets A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function setBudgets(Collection $budgets, ConnectionInterface $con = null)
    {
        /** @var ChildBudget[] $budgetsToDelete */
        $budgetsToDelete = $this->getBudgets(new Criteria(), $con)->diff($budgets);


        $this->budgetsScheduledForDeletion = $budgetsToDelete;

        foreach ($budgetsToDelete as $budgetRemoved) {
            $budgetRemoved->setBranch(null);
        }

        $this->collBudgets = null;
        foreach ($budgets as $budget) {
            $this->addBudget($budget);
        }

        $this->collBudgets = $budgets;
        $this->collBudgetsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Budget objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Budget objects.
     * @throws PropelException
     */
    public function countBudgets(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBudgetsPartial && !$this->isNew();
        if (null === $this->collBudgets || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBudgets) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBudgets());
            }

            $query = ChildBudgetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBranch($this)
                ->count($con);
        }

        return count($this->collBudgets);
    }

    /**
     * Method called to associate a ChildBudget object to this object
     * through the ChildBudget foreign key attribute.
     *
     * @param  ChildBudget $l ChildBudget
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function addBudget(ChildBudget $l)
    {
        if ($this->collBudgets === null) {
            $this->initBudgets();
            $this->collBudgetsPartial = true;
        }

        if (!$this->collBudgets->contains($l)) {
            $this->doAddBudget($l);

            if ($this->budgetsScheduledForDeletion and $this->budgetsScheduledForDeletion->contains($l)) {
                $this->budgetsScheduledForDeletion->remove($this->budgetsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBudget $budget The ChildBudget object to add.
     */
    protected function doAddBudget(ChildBudget $budget)
    {
        $this->collBudgets[]= $budget;
        $budget->setBranch($this);
    }

    /**
     * @param  ChildBudget $budget The ChildBudget object to remove.
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function removeBudget(ChildBudget $budget)
    {
        if ($this->getBudgets()->contains($budget)) {
            $pos = $this->collBudgets->search($budget);
            $this->collBudgets->remove($pos);
            if (null === $this->budgetsScheduledForDeletion) {
                $this->budgetsScheduledForDeletion = clone $this->collBudgets;
                $this->budgetsScheduledForDeletion->clear();
            }
            $this->budgetsScheduledForDeletion[]= $budget;
            $budget->setBranch(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Branch is new, it will return
     * an empty collection; or if this Branch has previously
     * been saved, it will retrieve related Budgets from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Branch.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBudget[] List of ChildBudget objects
     */
    public function getBudgetsJoinLocation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBudgetQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getBudgets($query, $con);
    }

    /**
     * Clears out the collPurchasingAgents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPurchasingAgents()
     */
    public function clearPurchasingAgents()
    {
        $this->collPurchasingAgents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPurchasingAgents collection loaded partially.
     */
    public function resetPartialPurchasingAgents($v = true)
    {
        $this->collPurchasingAgentsPartial = $v;
    }

    /**
     * Initializes the collPurchasingAgents collection.
     *
     * By default this just sets the collPurchasingAgents collection to an empty array (like clearcollPurchasingAgents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPurchasingAgents($overrideExisting = true)
    {
        if (null !== $this->collPurchasingAgents && !$overrideExisting) {
            return;
        }

        $collectionClassName = PurchasingAgentTableMap::getTableMap()->getCollectionClassName();

        $this->collPurchasingAgents = new $collectionClassName;
        $this->collPurchasingAgents->setModel('\PurchasingAgent');
    }

    /**
     * Gets an array of ChildPurchasingAgent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBranch is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPurchasingAgent[] List of ChildPurchasingAgent objects
     * @throws PropelException
     */
    public function getPurchasingAgents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasingAgentsPartial && !$this->isNew();
        if (null === $this->collPurchasingAgents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPurchasingAgents) {
                // return empty collection
                $this->initPurchasingAgents();
            } else {
                $collPurchasingAgents = ChildPurchasingAgentQuery::create(null, $criteria)
                    ->filterByBranch($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPurchasingAgentsPartial && count($collPurchasingAgents)) {
                        $this->initPurchasingAgents(false);

                        foreach ($collPurchasingAgents as $obj) {
                            if (false == $this->collPurchasingAgents->contains($obj)) {
                                $this->collPurchasingAgents->append($obj);
                            }
                        }

                        $this->collPurchasingAgentsPartial = true;
                    }

                    return $collPurchasingAgents;
                }

                if ($partial && $this->collPurchasingAgents) {
                    foreach ($this->collPurchasingAgents as $obj) {
                        if ($obj->isNew()) {
                            $collPurchasingAgents[] = $obj;
                        }
                    }
                }

                $this->collPurchasingAgents = $collPurchasingAgents;
                $this->collPurchasingAgentsPartial = false;
            }
        }

        return $this->collPurchasingAgents;
    }

    /**
     * Sets a collection of ChildPurchasingAgent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $purchasingAgents A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function setPurchasingAgents(Collection $purchasingAgents, ConnectionInterface $con = null)
    {
        /** @var ChildPurchasingAgent[] $purchasingAgentsToDelete */
        $purchasingAgentsToDelete = $this->getPurchasingAgents(new Criteria(), $con)->diff($purchasingAgents);


        $this->purchasingAgentsScheduledForDeletion = $purchasingAgentsToDelete;

        foreach ($purchasingAgentsToDelete as $purchasingAgentRemoved) {
            $purchasingAgentRemoved->setBranch(null);
        }

        $this->collPurchasingAgents = null;
        foreach ($purchasingAgents as $purchasingAgent) {
            $this->addPurchasingAgent($purchasingAgent);
        }

        $this->collPurchasingAgents = $purchasingAgents;
        $this->collPurchasingAgentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PurchasingAgent objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PurchasingAgent objects.
     * @throws PropelException
     */
    public function countPurchasingAgents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasingAgentsPartial && !$this->isNew();
        if (null === $this->collPurchasingAgents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPurchasingAgents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPurchasingAgents());
            }

            $query = ChildPurchasingAgentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBranch($this)
                ->count($con);
        }

        return count($this->collPurchasingAgents);
    }

    /**
     * Method called to associate a ChildPurchasingAgent object to this object
     * through the ChildPurchasingAgent foreign key attribute.
     *
     * @param  ChildPurchasingAgent $l ChildPurchasingAgent
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function addPurchasingAgent(ChildPurchasingAgent $l)
    {
        if ($this->collPurchasingAgents === null) {
            $this->initPurchasingAgents();
            $this->collPurchasingAgentsPartial = true;
        }

        if (!$this->collPurchasingAgents->contains($l)) {
            $this->doAddPurchasingAgent($l);

            if ($this->purchasingAgentsScheduledForDeletion and $this->purchasingAgentsScheduledForDeletion->contains($l)) {
                $this->purchasingAgentsScheduledForDeletion->remove($this->purchasingAgentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPurchasingAgent $purchasingAgent The ChildPurchasingAgent object to add.
     */
    protected function doAddPurchasingAgent(ChildPurchasingAgent $purchasingAgent)
    {
        $this->collPurchasingAgents[]= $purchasingAgent;
        $purchasingAgent->setBranch($this);
    }

    /**
     * @param  ChildPurchasingAgent $purchasingAgent The ChildPurchasingAgent object to remove.
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function removePurchasingAgent(ChildPurchasingAgent $purchasingAgent)
    {
        if ($this->getPurchasingAgents()->contains($purchasingAgent)) {
            $pos = $this->collPurchasingAgents->search($purchasingAgent);
            $this->collPurchasingAgents->remove($pos);
            if (null === $this->purchasingAgentsScheduledForDeletion) {
                $this->purchasingAgentsScheduledForDeletion = clone $this->collPurchasingAgents;
                $this->purchasingAgentsScheduledForDeletion->clear();
            }
            $this->purchasingAgentsScheduledForDeletion[]= clone $purchasingAgent;
            $purchasingAgent->setBranch(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Branch is new, it will return
     * an empty collection; or if this Branch has previously
     * been saved, it will retrieve related PurchasingAgents from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Branch.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchasingAgent[] List of ChildPurchasingAgent objects
     */
    public function getPurchasingAgentsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchasingAgentQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getPurchasingAgents($query, $con);
    }

    /**
     * Clears out the collSupervisors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSupervisors()
     */
    public function clearSupervisors()
    {
        $this->collSupervisors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSupervisors collection loaded partially.
     */
    public function resetPartialSupervisors($v = true)
    {
        $this->collSupervisorsPartial = $v;
    }

    /**
     * Initializes the collSupervisors collection.
     *
     * By default this just sets the collSupervisors collection to an empty array (like clearcollSupervisors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSupervisors($overrideExisting = true)
    {
        if (null !== $this->collSupervisors && !$overrideExisting) {
            return;
        }

        $collectionClassName = SupervisorTableMap::getTableMap()->getCollectionClassName();

        $this->collSupervisors = new $collectionClassName;
        $this->collSupervisors->setModel('\Supervisor');
    }

    /**
     * Gets an array of ChildSupervisor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBranch is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSupervisor[] List of ChildSupervisor objects
     * @throws PropelException
     */
    public function getSupervisors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSupervisorsPartial && !$this->isNew();
        if (null === $this->collSupervisors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSupervisors) {
                // return empty collection
                $this->initSupervisors();
            } else {
                $collSupervisors = ChildSupervisorQuery::create(null, $criteria)
                    ->filterByBranch($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSupervisorsPartial && count($collSupervisors)) {
                        $this->initSupervisors(false);

                        foreach ($collSupervisors as $obj) {
                            if (false == $this->collSupervisors->contains($obj)) {
                                $this->collSupervisors->append($obj);
                            }
                        }

                        $this->collSupervisorsPartial = true;
                    }

                    return $collSupervisors;
                }

                if ($partial && $this->collSupervisors) {
                    foreach ($this->collSupervisors as $obj) {
                        if ($obj->isNew()) {
                            $collSupervisors[] = $obj;
                        }
                    }
                }

                $this->collSupervisors = $collSupervisors;
                $this->collSupervisorsPartial = false;
            }
        }

        return $this->collSupervisors;
    }

    /**
     * Sets a collection of ChildSupervisor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $supervisors A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function setSupervisors(Collection $supervisors, ConnectionInterface $con = null)
    {
        /** @var ChildSupervisor[] $supervisorsToDelete */
        $supervisorsToDelete = $this->getSupervisors(new Criteria(), $con)->diff($supervisors);


        $this->supervisorsScheduledForDeletion = $supervisorsToDelete;

        foreach ($supervisorsToDelete as $supervisorRemoved) {
            $supervisorRemoved->setBranch(null);
        }

        $this->collSupervisors = null;
        foreach ($supervisors as $supervisor) {
            $this->addSupervisor($supervisor);
        }

        $this->collSupervisors = $supervisors;
        $this->collSupervisorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Supervisor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Supervisor objects.
     * @throws PropelException
     */
    public function countSupervisors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSupervisorsPartial && !$this->isNew();
        if (null === $this->collSupervisors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSupervisors) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSupervisors());
            }

            $query = ChildSupervisorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBranch($this)
                ->count($con);
        }

        return count($this->collSupervisors);
    }

    /**
     * Method called to associate a ChildSupervisor object to this object
     * through the ChildSupervisor foreign key attribute.
     *
     * @param  ChildSupervisor $l ChildSupervisor
     * @return $this|\Branch The current object (for fluent API support)
     */
    public function addSupervisor(ChildSupervisor $l)
    {
        if ($this->collSupervisors === null) {
            $this->initSupervisors();
            $this->collSupervisorsPartial = true;
        }

        if (!$this->collSupervisors->contains($l)) {
            $this->doAddSupervisor($l);

            if ($this->supervisorsScheduledForDeletion and $this->supervisorsScheduledForDeletion->contains($l)) {
                $this->supervisorsScheduledForDeletion->remove($this->supervisorsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSupervisor $supervisor The ChildSupervisor object to add.
     */
    protected function doAddSupervisor(ChildSupervisor $supervisor)
    {
        $this->collSupervisors[]= $supervisor;
        $supervisor->setBranch($this);
    }

    /**
     * @param  ChildSupervisor $supervisor The ChildSupervisor object to remove.
     * @return $this|ChildBranch The current object (for fluent API support)
     */
    public function removeSupervisor(ChildSupervisor $supervisor)
    {
        if ($this->getSupervisors()->contains($supervisor)) {
            $pos = $this->collSupervisors->search($supervisor);
            $this->collSupervisors->remove($pos);
            if (null === $this->supervisorsScheduledForDeletion) {
                $this->supervisorsScheduledForDeletion = clone $this->collSupervisors;
                $this->supervisorsScheduledForDeletion->clear();
            }
            $this->supervisorsScheduledForDeletion[]= clone $supervisor;
            $supervisor->setBranch(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Branch is new, it will return
     * an empty collection; or if this Branch has previously
     * been saved, it will retrieve related Supervisors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Branch.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSupervisor[] List of ChildSupervisor objects
     */
    public function getSupervisorsJoinManager(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSupervisorQuery::create(null, $criteria);
        $query->joinWith('Manager', $joinBehavior);

        return $this->getSupervisors($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Branch is new, it will return
     * an empty collection; or if this Branch has previously
     * been saved, it will retrieve related Supervisors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Branch.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSupervisor[] List of ChildSupervisor objects
     */
    public function getSupervisorsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSupervisorQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getSupervisors($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aLocation) {
            $this->aLocation->removeBranch($this);
        }
        $this->id = null;
        $this->location_id = null;
        $this->name = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collApprovedUsers) {
                foreach ($this->collApprovedUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBudgets) {
                foreach ($this->collBudgets as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPurchasingAgents) {
                foreach ($this->collPurchasingAgents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSupervisors) {
                foreach ($this->collSupervisors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collApprovedUsers = null;
        $this->collBudgets = null;
        $this->collPurchasingAgents = null;
        $this->collSupervisors = null;
        $this->aLocation = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BranchTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
