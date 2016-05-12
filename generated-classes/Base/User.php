<?php

namespace Base;

use \Admin as ChildAdmin;
use \AdminQuery as ChildAdminQuery;
use \ApprovedUser as ChildApprovedUser;
use \ApprovedUserQuery as ChildApprovedUserQuery;
use \Auditor as ChildAuditor;
use \AuditorQuery as ChildAuditorQuery;
use \Manager as ChildManager;
use \ManagerQuery as ChildManagerQuery;
use \PurchasingAgent as ChildPurchasingAgent;
use \PurchasingAgentQuery as ChildPurchasingAgentQuery;
use \Supervisor as ChildSupervisor;
use \SupervisorQuery as ChildSupervisorQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Exception;
use \PDO;
use Map\AdminTableMap;
use Map\ApprovedUserTableMap;
use Map\AuditorTableMap;
use Map\ManagerTableMap;
use Map\PurchasingAgentTableMap;
use Map\SupervisorTableMap;
use Map\UserTableMap;
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
 * Base class that represents a row from the 'user' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserTableMap';


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
     * The value for the firstname field.
     *
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     *
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the email_address field.
     *
     * @var        string
     */
    protected $email_address;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     *
     * @var        string
     */
    protected $password;

    /**
     * @var        ObjectCollection|ChildAdmin[] Collection to store aggregation of ChildAdmin objects.
     */
    protected $collAdmins;
    protected $collAdminsPartial;

    /**
     * @var        ObjectCollection|ChildApprovedUser[] Collection to store aggregation of ChildApprovedUser objects.
     */
    protected $collApprovedUsers;
    protected $collApprovedUsersPartial;

    /**
     * @var        ObjectCollection|ChildAuditor[] Collection to store aggregation of ChildAuditor objects.
     */
    protected $collAuditors;
    protected $collAuditorsPartial;

    /**
     * @var        ObjectCollection|ChildManager[] Collection to store aggregation of ChildManager objects.
     */
    protected $collManagers;
    protected $collManagersPartial;

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
     * @var ObjectCollection|ChildAdmin[]
     */
    protected $adminsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildApprovedUser[]
     */
    protected $approvedUsersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAuditor[]
     */
    protected $auditorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildManager[]
     */
    protected $managersScheduledForDeletion = null;

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
     * Initializes internal state of Base\User object.
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [firstname] column value.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the [email_address] column value.
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [firstname] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[UserTableMap::COL_FIRSTNAME] = true;
        }

        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[UserTableMap::COL_LASTNAME] = true;
        }

        return $this;
    } // setLastname()

    /**
     * Set the value of [email_address] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setEmailAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email_address !== $v) {
            $this->email_address = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL_ADDRESS] = true;
        }

        return $this;
    } // setEmailAddress()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('EmailAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAdmins = null;

            $this->collApprovedUsers = null;

            $this->collAuditors = null;

            $this->collManagers = null;

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
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
                UserTableMap::addInstanceToPool($this);
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

            if ($this->adminsScheduledForDeletion !== null) {
                if (!$this->adminsScheduledForDeletion->isEmpty()) {
                    \AdminQuery::create()
                        ->filterByPrimaryKeys($this->adminsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adminsScheduledForDeletion = null;
                }
            }

            if ($this->collAdmins !== null) {
                foreach ($this->collAdmins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->auditorsScheduledForDeletion !== null) {
                if (!$this->auditorsScheduledForDeletion->isEmpty()) {
                    \AuditorQuery::create()
                        ->filterByPrimaryKeys($this->auditorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->auditorsScheduledForDeletion = null;
                }
            }

            if ($this->collAuditors !== null) {
                foreach ($this->collAuditors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->managersScheduledForDeletion !== null) {
                if (!$this->managersScheduledForDeletion->isEmpty()) {
                    \ManagerQuery::create()
                        ->filterByPrimaryKeys($this->managersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->managersScheduledForDeletion = null;
                }
            }

            if ($this->collManagers !== null) {
                foreach ($this->collManagers as $referrerFK) {
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

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'firstname';
        }
        if ($this->isColumnModified(UserTableMap::COL_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'lastname';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'email_address';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
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
                    case 'firstname':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'lastname':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'email_address':
                        $stmt->bindValue($identifier, $this->email_address, PDO::PARAM_STR);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getFirstname();
                break;
            case 2:
                return $this->getLastname();
                break;
            case 3:
                return $this->getEmailAddress();
                break;
            case 4:
                return $this->getUsername();
                break;
            case 5:
                return $this->getPassword();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFirstname(),
            $keys[2] => $this->getLastname(),
            $keys[3] => $this->getEmailAddress(),
            $keys[4] => $this->getUsername(),
            $keys[5] => $this->getPassword(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAdmins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'admins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'admins';
                        break;
                    default:
                        $key = 'Admins';
                }

                $result[$key] = $this->collAdmins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collAuditors) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'auditors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'auditors';
                        break;
                    default:
                        $key = 'Auditors';
                }

                $result[$key] = $this->collAuditors->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collManagers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'managers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'managers';
                        break;
                    default:
                        $key = 'Managers';
                }

                $result[$key] = $this->collManagers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFirstname($value);
                break;
            case 2:
                $this->setLastname($value);
                break;
            case 3:
                $this->setEmailAddress($value);
                break;
            case 4:
                $this->setUsername($value);
                break;
            case 5:
                $this->setPassword($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFirstname($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLastname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmailAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUsername($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPassword($arr[$keys[5]]);
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
     * @return $this|\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRSTNAME)) {
            $criteria->add(UserTableMap::COL_FIRSTNAME, $this->firstname);
        }
        if ($this->isColumnModified(UserTableMap::COL_LASTNAME)) {
            $criteria->add(UserTableMap::COL_LASTNAME, $this->lastname);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL_ADDRESS)) {
            $criteria->add(UserTableMap::COL_EMAIL_ADDRESS, $this->email_address);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setEmailAddress($this->getEmailAddress());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAdmins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdmin($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getApprovedUsers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApprovedUser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuditors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuditor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getManagers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addManager($relObj->copy($deepCopy));
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
     * @return \User Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Admin' == $relationName) {
            return $this->initAdmins();
        }
        if ('ApprovedUser' == $relationName) {
            return $this->initApprovedUsers();
        }
        if ('Auditor' == $relationName) {
            return $this->initAuditors();
        }
        if ('Manager' == $relationName) {
            return $this->initManagers();
        }
        if ('PurchasingAgent' == $relationName) {
            return $this->initPurchasingAgents();
        }
        if ('Supervisor' == $relationName) {
            return $this->initSupervisors();
        }
    }

    /**
     * Clears out the collAdmins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAdmins()
     */
    public function clearAdmins()
    {
        $this->collAdmins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAdmins collection loaded partially.
     */
    public function resetPartialAdmins($v = true)
    {
        $this->collAdminsPartial = $v;
    }

    /**
     * Initializes the collAdmins collection.
     *
     * By default this just sets the collAdmins collection to an empty array (like clearcollAdmins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdmins($overrideExisting = true)
    {
        if (null !== $this->collAdmins && !$overrideExisting) {
            return;
        }

        $collectionClassName = AdminTableMap::getTableMap()->getCollectionClassName();

        $this->collAdmins = new $collectionClassName;
        $this->collAdmins->setModel('\Admin');
    }

    /**
     * Gets an array of ChildAdmin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAdmin[] List of ChildAdmin objects
     * @throws PropelException
     */
    public function getAdmins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAdminsPartial && !$this->isNew();
        if (null === $this->collAdmins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdmins) {
                // return empty collection
                $this->initAdmins();
            } else {
                $collAdmins = ChildAdminQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAdminsPartial && count($collAdmins)) {
                        $this->initAdmins(false);

                        foreach ($collAdmins as $obj) {
                            if (false == $this->collAdmins->contains($obj)) {
                                $this->collAdmins->append($obj);
                            }
                        }

                        $this->collAdminsPartial = true;
                    }

                    return $collAdmins;
                }

                if ($partial && $this->collAdmins) {
                    foreach ($this->collAdmins as $obj) {
                        if ($obj->isNew()) {
                            $collAdmins[] = $obj;
                        }
                    }
                }

                $this->collAdmins = $collAdmins;
                $this->collAdminsPartial = false;
            }
        }

        return $this->collAdmins;
    }

    /**
     * Sets a collection of ChildAdmin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $admins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setAdmins(Collection $admins, ConnectionInterface $con = null)
    {
        /** @var ChildAdmin[] $adminsToDelete */
        $adminsToDelete = $this->getAdmins(new Criteria(), $con)->diff($admins);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->adminsScheduledForDeletion = clone $adminsToDelete;

        foreach ($adminsToDelete as $adminRemoved) {
            $adminRemoved->setUser(null);
        }

        $this->collAdmins = null;
        foreach ($admins as $admin) {
            $this->addAdmin($admin);
        }

        $this->collAdmins = $admins;
        $this->collAdminsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Admin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Admin objects.
     * @throws PropelException
     */
    public function countAdmins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAdminsPartial && !$this->isNew();
        if (null === $this->collAdmins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdmins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdmins());
            }

            $query = ChildAdminQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collAdmins);
    }

    /**
     * Method called to associate a ChildAdmin object to this object
     * through the ChildAdmin foreign key attribute.
     *
     * @param  ChildAdmin $l ChildAdmin
     * @return $this|\User The current object (for fluent API support)
     */
    public function addAdmin(ChildAdmin $l)
    {
        if ($this->collAdmins === null) {
            $this->initAdmins();
            $this->collAdminsPartial = true;
        }

        if (!$this->collAdmins->contains($l)) {
            $this->doAddAdmin($l);

            if ($this->adminsScheduledForDeletion and $this->adminsScheduledForDeletion->contains($l)) {
                $this->adminsScheduledForDeletion->remove($this->adminsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAdmin $admin The ChildAdmin object to add.
     */
    protected function doAddAdmin(ChildAdmin $admin)
    {
        $this->collAdmins[]= $admin;
        $admin->setUser($this);
    }

    /**
     * @param  ChildAdmin $admin The ChildAdmin object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeAdmin(ChildAdmin $admin)
    {
        if ($this->getAdmins()->contains($admin)) {
            $pos = $this->collAdmins->search($admin);
            $this->collAdmins->remove($pos);
            if (null === $this->adminsScheduledForDeletion) {
                $this->adminsScheduledForDeletion = clone $this->collAdmins;
                $this->adminsScheduledForDeletion->clear();
            }
            $this->adminsScheduledForDeletion[]= clone $admin;
            $admin->setUser(null);
        }

        return $this;
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setApprovedUsers(Collection $approvedUsers, ConnectionInterface $con = null)
    {
        /** @var ChildApprovedUser[] $approvedUsersToDelete */
        $approvedUsersToDelete = $this->getApprovedUsers(new Criteria(), $con)->diff($approvedUsers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->approvedUsersScheduledForDeletion = clone $approvedUsersToDelete;

        foreach ($approvedUsersToDelete as $approvedUserRemoved) {
            $approvedUserRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collApprovedUsers);
    }

    /**
     * Method called to associate a ChildApprovedUser object to this object
     * through the ChildApprovedUser foreign key attribute.
     *
     * @param  ChildApprovedUser $l ChildApprovedUser
     * @return $this|\User The current object (for fluent API support)
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
        $approvedUser->setUser($this);
    }

    /**
     * @param  ChildApprovedUser $approvedUser The ChildApprovedUser object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $approvedUser->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ApprovedUsers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApprovedUser[] List of ChildApprovedUser objects
     */
    public function getApprovedUsersJoinBranch(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApprovedUserQuery::create(null, $criteria);
        $query->joinWith('Branch', $joinBehavior);

        return $this->getApprovedUsers($query, $con);
    }

    /**
     * Clears out the collAuditors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAuditors()
     */
    public function clearAuditors()
    {
        $this->collAuditors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAuditors collection loaded partially.
     */
    public function resetPartialAuditors($v = true)
    {
        $this->collAuditorsPartial = $v;
    }

    /**
     * Initializes the collAuditors collection.
     *
     * By default this just sets the collAuditors collection to an empty array (like clearcollAuditors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuditors($overrideExisting = true)
    {
        if (null !== $this->collAuditors && !$overrideExisting) {
            return;
        }

        $collectionClassName = AuditorTableMap::getTableMap()->getCollectionClassName();

        $this->collAuditors = new $collectionClassName;
        $this->collAuditors->setModel('\Auditor');
    }

    /**
     * Gets an array of ChildAuditor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAuditor[] List of ChildAuditor objects
     * @throws PropelException
     */
    public function getAuditors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAuditorsPartial && !$this->isNew();
        if (null === $this->collAuditors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuditors) {
                // return empty collection
                $this->initAuditors();
            } else {
                $collAuditors = ChildAuditorQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAuditorsPartial && count($collAuditors)) {
                        $this->initAuditors(false);

                        foreach ($collAuditors as $obj) {
                            if (false == $this->collAuditors->contains($obj)) {
                                $this->collAuditors->append($obj);
                            }
                        }

                        $this->collAuditorsPartial = true;
                    }

                    return $collAuditors;
                }

                if ($partial && $this->collAuditors) {
                    foreach ($this->collAuditors as $obj) {
                        if ($obj->isNew()) {
                            $collAuditors[] = $obj;
                        }
                    }
                }

                $this->collAuditors = $collAuditors;
                $this->collAuditorsPartial = false;
            }
        }

        return $this->collAuditors;
    }

    /**
     * Sets a collection of ChildAuditor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $auditors A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setAuditors(Collection $auditors, ConnectionInterface $con = null)
    {
        /** @var ChildAuditor[] $auditorsToDelete */
        $auditorsToDelete = $this->getAuditors(new Criteria(), $con)->diff($auditors);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->auditorsScheduledForDeletion = clone $auditorsToDelete;

        foreach ($auditorsToDelete as $auditorRemoved) {
            $auditorRemoved->setUser(null);
        }

        $this->collAuditors = null;
        foreach ($auditors as $auditor) {
            $this->addAuditor($auditor);
        }

        $this->collAuditors = $auditors;
        $this->collAuditorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Auditor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Auditor objects.
     * @throws PropelException
     */
    public function countAuditors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAuditorsPartial && !$this->isNew();
        if (null === $this->collAuditors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuditors) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuditors());
            }

            $query = ChildAuditorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collAuditors);
    }

    /**
     * Method called to associate a ChildAuditor object to this object
     * through the ChildAuditor foreign key attribute.
     *
     * @param  ChildAuditor $l ChildAuditor
     * @return $this|\User The current object (for fluent API support)
     */
    public function addAuditor(ChildAuditor $l)
    {
        if ($this->collAuditors === null) {
            $this->initAuditors();
            $this->collAuditorsPartial = true;
        }

        if (!$this->collAuditors->contains($l)) {
            $this->doAddAuditor($l);

            if ($this->auditorsScheduledForDeletion and $this->auditorsScheduledForDeletion->contains($l)) {
                $this->auditorsScheduledForDeletion->remove($this->auditorsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAuditor $auditor The ChildAuditor object to add.
     */
    protected function doAddAuditor(ChildAuditor $auditor)
    {
        $this->collAuditors[]= $auditor;
        $auditor->setUser($this);
    }

    /**
     * @param  ChildAuditor $auditor The ChildAuditor object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeAuditor(ChildAuditor $auditor)
    {
        if ($this->getAuditors()->contains($auditor)) {
            $pos = $this->collAuditors->search($auditor);
            $this->collAuditors->remove($pos);
            if (null === $this->auditorsScheduledForDeletion) {
                $this->auditorsScheduledForDeletion = clone $this->collAuditors;
                $this->auditorsScheduledForDeletion->clear();
            }
            $this->auditorsScheduledForDeletion[]= clone $auditor;
            $auditor->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Auditors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAuditor[] List of ChildAuditor objects
     */
    public function getAuditorsJoinLocation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAuditorQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getAuditors($query, $con);
    }

    /**
     * Clears out the collManagers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addManagers()
     */
    public function clearManagers()
    {
        $this->collManagers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collManagers collection loaded partially.
     */
    public function resetPartialManagers($v = true)
    {
        $this->collManagersPartial = $v;
    }

    /**
     * Initializes the collManagers collection.
     *
     * By default this just sets the collManagers collection to an empty array (like clearcollManagers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initManagers($overrideExisting = true)
    {
        if (null !== $this->collManagers && !$overrideExisting) {
            return;
        }

        $collectionClassName = ManagerTableMap::getTableMap()->getCollectionClassName();

        $this->collManagers = new $collectionClassName;
        $this->collManagers->setModel('\Manager');
    }

    /**
     * Gets an array of ChildManager objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildManager[] List of ChildManager objects
     * @throws PropelException
     */
    public function getManagers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collManagersPartial && !$this->isNew();
        if (null === $this->collManagers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collManagers) {
                // return empty collection
                $this->initManagers();
            } else {
                $collManagers = ChildManagerQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collManagersPartial && count($collManagers)) {
                        $this->initManagers(false);

                        foreach ($collManagers as $obj) {
                            if (false == $this->collManagers->contains($obj)) {
                                $this->collManagers->append($obj);
                            }
                        }

                        $this->collManagersPartial = true;
                    }

                    return $collManagers;
                }

                if ($partial && $this->collManagers) {
                    foreach ($this->collManagers as $obj) {
                        if ($obj->isNew()) {
                            $collManagers[] = $obj;
                        }
                    }
                }

                $this->collManagers = $collManagers;
                $this->collManagersPartial = false;
            }
        }

        return $this->collManagers;
    }

    /**
     * Sets a collection of ChildManager objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $managers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setManagers(Collection $managers, ConnectionInterface $con = null)
    {
        /** @var ChildManager[] $managersToDelete */
        $managersToDelete = $this->getManagers(new Criteria(), $con)->diff($managers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->managersScheduledForDeletion = clone $managersToDelete;

        foreach ($managersToDelete as $managerRemoved) {
            $managerRemoved->setUser(null);
        }

        $this->collManagers = null;
        foreach ($managers as $manager) {
            $this->addManager($manager);
        }

        $this->collManagers = $managers;
        $this->collManagersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Manager objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Manager objects.
     * @throws PropelException
     */
    public function countManagers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collManagersPartial && !$this->isNew();
        if (null === $this->collManagers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collManagers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getManagers());
            }

            $query = ChildManagerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collManagers);
    }

    /**
     * Method called to associate a ChildManager object to this object
     * through the ChildManager foreign key attribute.
     *
     * @param  ChildManager $l ChildManager
     * @return $this|\User The current object (for fluent API support)
     */
    public function addManager(ChildManager $l)
    {
        if ($this->collManagers === null) {
            $this->initManagers();
            $this->collManagersPartial = true;
        }

        if (!$this->collManagers->contains($l)) {
            $this->doAddManager($l);

            if ($this->managersScheduledForDeletion and $this->managersScheduledForDeletion->contains($l)) {
                $this->managersScheduledForDeletion->remove($this->managersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildManager $manager The ChildManager object to add.
     */
    protected function doAddManager(ChildManager $manager)
    {
        $this->collManagers[]= $manager;
        $manager->setUser($this);
    }

    /**
     * @param  ChildManager $manager The ChildManager object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeManager(ChildManager $manager)
    {
        if ($this->getManagers()->contains($manager)) {
            $pos = $this->collManagers->search($manager);
            $this->collManagers->remove($pos);
            if (null === $this->managersScheduledForDeletion) {
                $this->managersScheduledForDeletion = clone $this->collManagers;
                $this->managersScheduledForDeletion->clear();
            }
            $this->managersScheduledForDeletion[]= clone $manager;
            $manager->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Managers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildManager[] List of ChildManager objects
     */
    public function getManagersJoinAdmin(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildManagerQuery::create(null, $criteria);
        $query->joinWith('Admin', $joinBehavior);

        return $this->getManagers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Managers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildManager[] List of ChildManager objects
     */
    public function getManagersJoinLocation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildManagerQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getManagers($query, $con);
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPurchasingAgents(Collection $purchasingAgents, ConnectionInterface $con = null)
    {
        /** @var ChildPurchasingAgent[] $purchasingAgentsToDelete */
        $purchasingAgentsToDelete = $this->getPurchasingAgents(new Criteria(), $con)->diff($purchasingAgents);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->purchasingAgentsScheduledForDeletion = clone $purchasingAgentsToDelete;

        foreach ($purchasingAgentsToDelete as $purchasingAgentRemoved) {
            $purchasingAgentRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collPurchasingAgents);
    }

    /**
     * Method called to associate a ChildPurchasingAgent object to this object
     * through the ChildPurchasingAgent foreign key attribute.
     *
     * @param  ChildPurchasingAgent $l ChildPurchasingAgent
     * @return $this|\User The current object (for fluent API support)
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
        $purchasingAgent->setUser($this);
    }

    /**
     * @param  ChildPurchasingAgent $purchasingAgent The ChildPurchasingAgent object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $purchasingAgent->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PurchasingAgents from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchasingAgent[] List of ChildPurchasingAgent objects
     */
    public function getPurchasingAgentsJoinBranch(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchasingAgentQuery::create(null, $criteria);
        $query->joinWith('Branch', $joinBehavior);

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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setSupervisors(Collection $supervisors, ConnectionInterface $con = null)
    {
        /** @var ChildSupervisor[] $supervisorsToDelete */
        $supervisorsToDelete = $this->getSupervisors(new Criteria(), $con)->diff($supervisors);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->supervisorsScheduledForDeletion = clone $supervisorsToDelete;

        foreach ($supervisorsToDelete as $supervisorRemoved) {
            $supervisorRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collSupervisors);
    }

    /**
     * Method called to associate a ChildSupervisor object to this object
     * through the ChildSupervisor foreign key attribute.
     *
     * @param  ChildSupervisor $l ChildSupervisor
     * @return $this|\User The current object (for fluent API support)
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
        $supervisor->setUser($this);
    }

    /**
     * @param  ChildSupervisor $supervisor The ChildSupervisor object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $supervisor->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Supervisors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
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
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Supervisors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSupervisor[] List of ChildSupervisor objects
     */
    public function getSupervisorsJoinBranch(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSupervisorQuery::create(null, $criteria);
        $query->joinWith('Branch', $joinBehavior);

        return $this->getSupervisors($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->email_address = null;
        $this->username = null;
        $this->password = null;
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
            if ($this->collAdmins) {
                foreach ($this->collAdmins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collApprovedUsers) {
                foreach ($this->collApprovedUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuditors) {
                foreach ($this->collAuditors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collManagers) {
                foreach ($this->collManagers as $o) {
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

        $this->collAdmins = null;
        $this->collApprovedUsers = null;
        $this->collAuditors = null;
        $this->collManagers = null;
        $this->collPurchasingAgents = null;
        $this->collSupervisors = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
