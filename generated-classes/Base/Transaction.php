<?php

namespace Base;

use \Purchase as ChildPurchase;
use \PurchaseQuery as ChildPurchaseQuery;
use \PurchasingAgent as ChildPurchasingAgent;
use \PurchasingAgentQuery as ChildPurchasingAgentQuery;
use \Refund as ChildRefund;
use \RefundQuery as ChildRefundQuery;
use \Supervisor as ChildSupervisor;
use \SupervisorQuery as ChildSupervisorQuery;
use \Transaction as ChildTransaction;
use \TransactionQuery as ChildTransactionQuery;
use \Exception;
use \PDO;
use Map\PurchaseTableMap;
use Map\RefundTableMap;
use Map\TransactionTableMap;
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
 * Base class that represents a row from the 'transaction' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Transaction implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TransactionTableMap';


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
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the type field.
     *
     * Note: this column has a database default value of: 'internal'
     * @var        string
     */
    protected $type;

    /**
     * The value for the purchasing_agent_id field.
     *
     * @var        int
     */
    protected $purchasing_agent_id;

    /**
     * The value for the supervisor_id field.
     *
     * @var        int
     */
    protected $supervisor_id;

    /**
     * @var        ChildPurchasingAgent
     */
    protected $aPurchasingAgent;

    /**
     * @var        ChildSupervisor
     */
    protected $aSupervisor;

    /**
     * @var        ObjectCollection|ChildPurchase[] Collection to store aggregation of ChildPurchase objects.
     */
    protected $collPurchases;
    protected $collPurchasesPartial;

    /**
     * @var        ObjectCollection|ChildRefund[] Collection to store aggregation of ChildRefund objects.
     */
    protected $collRefunds;
    protected $collRefundsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPurchase[]
     */
    protected $purchasesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRefund[]
     */
    protected $refundsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->type = 'internal';
    }

    /**
     * Initializes internal state of Base\Transaction object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Transaction</code> instance.  If
     * <code>obj</code> is an instance of <code>Transaction</code>, delegates to
     * <code>equals(Transaction)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Transaction The current object, for fluid interface
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
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [purchasing_agent_id] column value.
     *
     * @return int
     */
    public function getPurchasingAgentId()
    {
        return $this->purchasing_agent_id;
    }

    /**
     * Get the [supervisor_id] column value.
     *
     * @return int
     */
    public function getSupervisorId()
    {
        return $this->supervisor_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TransactionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[TransactionTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[TransactionTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [purchasing_agent_id] column.
     *
     * @param int $v new value
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function setPurchasingAgentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->purchasing_agent_id !== $v) {
            $this->purchasing_agent_id = $v;
            $this->modifiedColumns[TransactionTableMap::COL_PURCHASING_AGENT_ID] = true;
        }

        if ($this->aPurchasingAgent !== null && $this->aPurchasingAgent->getId() !== $v) {
            $this->aPurchasingAgent = null;
        }

        return $this;
    } // setPurchasingAgentId()

    /**
     * Set the value of [supervisor_id] column.
     *
     * @param int $v new value
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function setSupervisorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->supervisor_id !== $v) {
            $this->supervisor_id = $v;
            $this->modifiedColumns[TransactionTableMap::COL_SUPERVISOR_ID] = true;
        }

        if ($this->aSupervisor !== null && $this->aSupervisor->getId() !== $v) {
            $this->aSupervisor = null;
        }

        return $this;
    } // setSupervisorId()

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
            if ($this->type !== 'internal') {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TransactionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TransactionTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TransactionTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TransactionTableMap::translateFieldName('PurchasingAgentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->purchasing_agent_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TransactionTableMap::translateFieldName('SupervisorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->supervisor_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = TransactionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Transaction'), 0, $e);
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
        if ($this->aPurchasingAgent !== null && $this->purchasing_agent_id !== $this->aPurchasingAgent->getId()) {
            $this->aPurchasingAgent = null;
        }
        if ($this->aSupervisor !== null && $this->supervisor_id !== $this->aSupervisor->getId()) {
            $this->aSupervisor = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(TransactionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTransactionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPurchasingAgent = null;
            $this->aSupervisor = null;
            $this->collPurchases = null;

            $this->collRefunds = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Transaction::setDeleted()
     * @see Transaction::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTransactionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
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
                TransactionTableMap::addInstanceToPool($this);
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

            if ($this->aPurchasingAgent !== null) {
                if ($this->aPurchasingAgent->isModified() || $this->aPurchasingAgent->isNew()) {
                    $affectedRows += $this->aPurchasingAgent->save($con);
                }
                $this->setPurchasingAgent($this->aPurchasingAgent);
            }

            if ($this->aSupervisor !== null) {
                if ($this->aSupervisor->isModified() || $this->aSupervisor->isNew()) {
                    $affectedRows += $this->aSupervisor->save($con);
                }
                $this->setSupervisor($this->aSupervisor);
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

            if ($this->purchasesScheduledForDeletion !== null) {
                if (!$this->purchasesScheduledForDeletion->isEmpty()) {
                    \PurchaseQuery::create()
                        ->filterByPrimaryKeys($this->purchasesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->purchasesScheduledForDeletion = null;
                }
            }

            if ($this->collPurchases !== null) {
                foreach ($this->collPurchases as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->refundsScheduledForDeletion !== null) {
                if (!$this->refundsScheduledForDeletion->isEmpty()) {
                    \RefundQuery::create()
                        ->filterByPrimaryKeys($this->refundsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->refundsScheduledForDeletion = null;
                }
            }

            if ($this->collRefunds !== null) {
                foreach ($this->collRefunds as $referrerFK) {
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

        $this->modifiedColumns[TransactionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TransactionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TransactionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TransactionTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(TransactionTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(TransactionTableMap::COL_PURCHASING_AGENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'purchasing_agent_id';
        }
        if ($this->isColumnModified(TransactionTableMap::COL_SUPERVISOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'supervisor_id';
        }

        $sql = sprintf(
            'INSERT INTO transaction (%s) VALUES (%s)',
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
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'purchasing_agent_id':
                        $stmt->bindValue($identifier, $this->purchasing_agent_id, PDO::PARAM_INT);
                        break;
                    case 'supervisor_id':
                        $stmt->bindValue($identifier, $this->supervisor_id, PDO::PARAM_INT);
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
        $pos = TransactionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDescription();
                break;
            case 2:
                return $this->getType();
                break;
            case 3:
                return $this->getPurchasingAgentId();
                break;
            case 4:
                return $this->getSupervisorId();
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

        if (isset($alreadyDumpedObjects['Transaction'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Transaction'][$this->hashCode()] = true;
        $keys = TransactionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDescription(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getPurchasingAgentId(),
            $keys[4] => $this->getSupervisorId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPurchasingAgent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'purchasingAgent';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'purchasing_agent';
                        break;
                    default:
                        $key = 'PurchasingAgent';
                }

                $result[$key] = $this->aPurchasingAgent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSupervisor) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'supervisor';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'supervisor';
                        break;
                    default:
                        $key = 'Supervisor';
                }

                $result[$key] = $this->aSupervisor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPurchases) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'purchases';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'purchases';
                        break;
                    default:
                        $key = 'Purchases';
                }

                $result[$key] = $this->collPurchases->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRefunds) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'refunds';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'refunds';
                        break;
                    default:
                        $key = 'Refunds';
                }

                $result[$key] = $this->collRefunds->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Transaction
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TransactionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Transaction
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDescription($value);
                break;
            case 2:
                $this->setType($value);
                break;
            case 3:
                $this->setPurchasingAgentId($value);
                break;
            case 4:
                $this->setSupervisorId($value);
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
        $keys = TransactionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDescription($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPurchasingAgentId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSupervisorId($arr[$keys[4]]);
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
     * @return $this|\Transaction The current object, for fluid interface
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
        $criteria = new Criteria(TransactionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TransactionTableMap::COL_ID)) {
            $criteria->add(TransactionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TransactionTableMap::COL_DESCRIPTION)) {
            $criteria->add(TransactionTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(TransactionTableMap::COL_TYPE)) {
            $criteria->add(TransactionTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(TransactionTableMap::COL_PURCHASING_AGENT_ID)) {
            $criteria->add(TransactionTableMap::COL_PURCHASING_AGENT_ID, $this->purchasing_agent_id);
        }
        if ($this->isColumnModified(TransactionTableMap::COL_SUPERVISOR_ID)) {
            $criteria->add(TransactionTableMap::COL_SUPERVISOR_ID, $this->supervisor_id);
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
        $criteria = ChildTransactionQuery::create();
        $criteria->add(TransactionTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Transaction (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDescription($this->getDescription());
        $copyObj->setType($this->getType());
        $copyObj->setPurchasingAgentId($this->getPurchasingAgentId());
        $copyObj->setSupervisorId($this->getSupervisorId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPurchases() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPurchase($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRefunds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRefund($relObj->copy($deepCopy));
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
     * @return \Transaction Clone of current object.
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
     * Declares an association between this object and a ChildPurchasingAgent object.
     *
     * @param  ChildPurchasingAgent $v
     * @return $this|\Transaction The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPurchasingAgent(ChildPurchasingAgent $v = null)
    {
        if ($v === null) {
            $this->setPurchasingAgentId(NULL);
        } else {
            $this->setPurchasingAgentId($v->getId());
        }

        $this->aPurchasingAgent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPurchasingAgent object, it will not be re-added.
        if ($v !== null) {
            $v->addTransaction($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPurchasingAgent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPurchasingAgent The associated ChildPurchasingAgent object.
     * @throws PropelException
     */
    public function getPurchasingAgent(ConnectionInterface $con = null)
    {
        if ($this->aPurchasingAgent === null && ($this->purchasing_agent_id !== null)) {
            $this->aPurchasingAgent = ChildPurchasingAgentQuery::create()
                ->filterByTransaction($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPurchasingAgent->addTransactions($this);
             */
        }

        return $this->aPurchasingAgent;
    }

    /**
     * Declares an association between this object and a ChildSupervisor object.
     *
     * @param  ChildSupervisor $v
     * @return $this|\Transaction The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSupervisor(ChildSupervisor $v = null)
    {
        if ($v === null) {
            $this->setSupervisorId(NULL);
        } else {
            $this->setSupervisorId($v->getId());
        }

        $this->aSupervisor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSupervisor object, it will not be re-added.
        if ($v !== null) {
            $v->addTransaction($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSupervisor object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSupervisor The associated ChildSupervisor object.
     * @throws PropelException
     */
    public function getSupervisor(ConnectionInterface $con = null)
    {
        if ($this->aSupervisor === null && ($this->supervisor_id !== null)) {
            $this->aSupervisor = ChildSupervisorQuery::create()
                ->filterByTransaction($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSupervisor->addTransactions($this);
             */
        }

        return $this->aSupervisor;
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
        if ('Purchase' == $relationName) {
            return $this->initPurchases();
        }
        if ('Refund' == $relationName) {
            return $this->initRefunds();
        }
    }

    /**
     * Clears out the collPurchases collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPurchases()
     */
    public function clearPurchases()
    {
        $this->collPurchases = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPurchases collection loaded partially.
     */
    public function resetPartialPurchases($v = true)
    {
        $this->collPurchasesPartial = $v;
    }

    /**
     * Initializes the collPurchases collection.
     *
     * By default this just sets the collPurchases collection to an empty array (like clearcollPurchases());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPurchases($overrideExisting = true)
    {
        if (null !== $this->collPurchases && !$overrideExisting) {
            return;
        }

        $collectionClassName = PurchaseTableMap::getTableMap()->getCollectionClassName();

        $this->collPurchases = new $collectionClassName;
        $this->collPurchases->setModel('\Purchase');
    }

    /**
     * Gets an array of ChildPurchase objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTransaction is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPurchase[] List of ChildPurchase objects
     * @throws PropelException
     */
    public function getPurchases(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasesPartial && !$this->isNew();
        if (null === $this->collPurchases || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPurchases) {
                // return empty collection
                $this->initPurchases();
            } else {
                $collPurchases = ChildPurchaseQuery::create(null, $criteria)
                    ->filterByTransaction($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPurchasesPartial && count($collPurchases)) {
                        $this->initPurchases(false);

                        foreach ($collPurchases as $obj) {
                            if (false == $this->collPurchases->contains($obj)) {
                                $this->collPurchases->append($obj);
                            }
                        }

                        $this->collPurchasesPartial = true;
                    }

                    return $collPurchases;
                }

                if ($partial && $this->collPurchases) {
                    foreach ($this->collPurchases as $obj) {
                        if ($obj->isNew()) {
                            $collPurchases[] = $obj;
                        }
                    }
                }

                $this->collPurchases = $collPurchases;
                $this->collPurchasesPartial = false;
            }
        }

        return $this->collPurchases;
    }

    /**
     * Sets a collection of ChildPurchase objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $purchases A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTransaction The current object (for fluent API support)
     */
    public function setPurchases(Collection $purchases, ConnectionInterface $con = null)
    {
        /** @var ChildPurchase[] $purchasesToDelete */
        $purchasesToDelete = $this->getPurchases(new Criteria(), $con)->diff($purchases);


        $this->purchasesScheduledForDeletion = $purchasesToDelete;

        foreach ($purchasesToDelete as $purchaseRemoved) {
            $purchaseRemoved->setTransaction(null);
        }

        $this->collPurchases = null;
        foreach ($purchases as $purchase) {
            $this->addPurchase($purchase);
        }

        $this->collPurchases = $purchases;
        $this->collPurchasesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Purchase objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Purchase objects.
     * @throws PropelException
     */
    public function countPurchases(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasesPartial && !$this->isNew();
        if (null === $this->collPurchases || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPurchases) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPurchases());
            }

            $query = ChildPurchaseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTransaction($this)
                ->count($con);
        }

        return count($this->collPurchases);
    }

    /**
     * Method called to associate a ChildPurchase object to this object
     * through the ChildPurchase foreign key attribute.
     *
     * @param  ChildPurchase $l ChildPurchase
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function addPurchase(ChildPurchase $l)
    {
        if ($this->collPurchases === null) {
            $this->initPurchases();
            $this->collPurchasesPartial = true;
        }

        if (!$this->collPurchases->contains($l)) {
            $this->doAddPurchase($l);

            if ($this->purchasesScheduledForDeletion and $this->purchasesScheduledForDeletion->contains($l)) {
                $this->purchasesScheduledForDeletion->remove($this->purchasesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPurchase $purchase The ChildPurchase object to add.
     */
    protected function doAddPurchase(ChildPurchase $purchase)
    {
        $this->collPurchases[]= $purchase;
        $purchase->setTransaction($this);
    }

    /**
     * @param  ChildPurchase $purchase The ChildPurchase object to remove.
     * @return $this|ChildTransaction The current object (for fluent API support)
     */
    public function removePurchase(ChildPurchase $purchase)
    {
        if ($this->getPurchases()->contains($purchase)) {
            $pos = $this->collPurchases->search($purchase);
            $this->collPurchases->remove($pos);
            if (null === $this->purchasesScheduledForDeletion) {
                $this->purchasesScheduledForDeletion = clone $this->collPurchases;
                $this->purchasesScheduledForDeletion->clear();
            }
            $this->purchasesScheduledForDeletion[]= clone $purchase;
            $purchase->setTransaction(null);
        }

        return $this;
    }

    /**
     * Clears out the collRefunds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRefunds()
     */
    public function clearRefunds()
    {
        $this->collRefunds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRefunds collection loaded partially.
     */
    public function resetPartialRefunds($v = true)
    {
        $this->collRefundsPartial = $v;
    }

    /**
     * Initializes the collRefunds collection.
     *
     * By default this just sets the collRefunds collection to an empty array (like clearcollRefunds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRefunds($overrideExisting = true)
    {
        if (null !== $this->collRefunds && !$overrideExisting) {
            return;
        }

        $collectionClassName = RefundTableMap::getTableMap()->getCollectionClassName();

        $this->collRefunds = new $collectionClassName;
        $this->collRefunds->setModel('\Refund');
    }

    /**
     * Gets an array of ChildRefund objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTransaction is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRefund[] List of ChildRefund objects
     * @throws PropelException
     */
    public function getRefunds(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRefundsPartial && !$this->isNew();
        if (null === $this->collRefunds || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRefunds) {
                // return empty collection
                $this->initRefunds();
            } else {
                $collRefunds = ChildRefundQuery::create(null, $criteria)
                    ->filterByTransaction($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRefundsPartial && count($collRefunds)) {
                        $this->initRefunds(false);

                        foreach ($collRefunds as $obj) {
                            if (false == $this->collRefunds->contains($obj)) {
                                $this->collRefunds->append($obj);
                            }
                        }

                        $this->collRefundsPartial = true;
                    }

                    return $collRefunds;
                }

                if ($partial && $this->collRefunds) {
                    foreach ($this->collRefunds as $obj) {
                        if ($obj->isNew()) {
                            $collRefunds[] = $obj;
                        }
                    }
                }

                $this->collRefunds = $collRefunds;
                $this->collRefundsPartial = false;
            }
        }

        return $this->collRefunds;
    }

    /**
     * Sets a collection of ChildRefund objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $refunds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTransaction The current object (for fluent API support)
     */
    public function setRefunds(Collection $refunds, ConnectionInterface $con = null)
    {
        /** @var ChildRefund[] $refundsToDelete */
        $refundsToDelete = $this->getRefunds(new Criteria(), $con)->diff($refunds);


        $this->refundsScheduledForDeletion = $refundsToDelete;

        foreach ($refundsToDelete as $refundRemoved) {
            $refundRemoved->setTransaction(null);
        }

        $this->collRefunds = null;
        foreach ($refunds as $refund) {
            $this->addRefund($refund);
        }

        $this->collRefunds = $refunds;
        $this->collRefundsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Refund objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Refund objects.
     * @throws PropelException
     */
    public function countRefunds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRefundsPartial && !$this->isNew();
        if (null === $this->collRefunds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRefunds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRefunds());
            }

            $query = ChildRefundQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTransaction($this)
                ->count($con);
        }

        return count($this->collRefunds);
    }

    /**
     * Method called to associate a ChildRefund object to this object
     * through the ChildRefund foreign key attribute.
     *
     * @param  ChildRefund $l ChildRefund
     * @return $this|\Transaction The current object (for fluent API support)
     */
    public function addRefund(ChildRefund $l)
    {
        if ($this->collRefunds === null) {
            $this->initRefunds();
            $this->collRefundsPartial = true;
        }

        if (!$this->collRefunds->contains($l)) {
            $this->doAddRefund($l);

            if ($this->refundsScheduledForDeletion and $this->refundsScheduledForDeletion->contains($l)) {
                $this->refundsScheduledForDeletion->remove($this->refundsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRefund $refund The ChildRefund object to add.
     */
    protected function doAddRefund(ChildRefund $refund)
    {
        $this->collRefunds[]= $refund;
        $refund->setTransaction($this);
    }

    /**
     * @param  ChildRefund $refund The ChildRefund object to remove.
     * @return $this|ChildTransaction The current object (for fluent API support)
     */
    public function removeRefund(ChildRefund $refund)
    {
        if ($this->getRefunds()->contains($refund)) {
            $pos = $this->collRefunds->search($refund);
            $this->collRefunds->remove($pos);
            if (null === $this->refundsScheduledForDeletion) {
                $this->refundsScheduledForDeletion = clone $this->collRefunds;
                $this->refundsScheduledForDeletion->clear();
            }
            $this->refundsScheduledForDeletion[]= clone $refund;
            $refund->setTransaction(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPurchasingAgent) {
            $this->aPurchasingAgent->removeTransaction($this);
        }
        if (null !== $this->aSupervisor) {
            $this->aSupervisor->removeTransaction($this);
        }
        $this->id = null;
        $this->description = null;
        $this->type = null;
        $this->purchasing_agent_id = null;
        $this->supervisor_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collPurchases) {
                foreach ($this->collPurchases as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRefunds) {
                foreach ($this->collRefunds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPurchases = null;
        $this->collRefunds = null;
        $this->aPurchasingAgent = null;
        $this->aSupervisor = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TransactionTableMap::DEFAULT_STRING_FORMAT);
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
