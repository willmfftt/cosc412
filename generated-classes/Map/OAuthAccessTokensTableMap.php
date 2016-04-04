<?php

namespace Map;

use \OAuthAccessTokens;
use \OAuthAccessTokensQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'oauth_access_tokens' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OAuthAccessTokensTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.OAuthAccessTokensTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'oauth_access_tokens';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\OAuthAccessTokens';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'OAuthAccessTokens';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the access_token field
     */
    const COL_ACCESS_TOKEN = 'oauth_access_tokens.access_token';

    /**
     * the column name for the client_id field
     */
    const COL_CLIENT_ID = 'oauth_access_tokens.client_id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'oauth_access_tokens.user_id';

    /**
     * the column name for the expires field
     */
    const COL_EXPIRES = 'oauth_access_tokens.expires';

    /**
     * the column name for the scope field
     */
    const COL_SCOPE = 'oauth_access_tokens.scope';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('AccessToken', 'ClientId', 'UserId', 'Expires', 'Scope', ),
        self::TYPE_CAMELNAME     => array('accessToken', 'clientId', 'userId', 'expires', 'scope', ),
        self::TYPE_COLNAME       => array(OAuthAccessTokensTableMap::COL_ACCESS_TOKEN, OAuthAccessTokensTableMap::COL_CLIENT_ID, OAuthAccessTokensTableMap::COL_USER_ID, OAuthAccessTokensTableMap::COL_EXPIRES, OAuthAccessTokensTableMap::COL_SCOPE, ),
        self::TYPE_FIELDNAME     => array('access_token', 'client_id', 'user_id', 'expires', 'scope', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('AccessToken' => 0, 'ClientId' => 1, 'UserId' => 2, 'Expires' => 3, 'Scope' => 4, ),
        self::TYPE_CAMELNAME     => array('accessToken' => 0, 'clientId' => 1, 'userId' => 2, 'expires' => 3, 'scope' => 4, ),
        self::TYPE_COLNAME       => array(OAuthAccessTokensTableMap::COL_ACCESS_TOKEN => 0, OAuthAccessTokensTableMap::COL_CLIENT_ID => 1, OAuthAccessTokensTableMap::COL_USER_ID => 2, OAuthAccessTokensTableMap::COL_EXPIRES => 3, OAuthAccessTokensTableMap::COL_SCOPE => 4, ),
        self::TYPE_FIELDNAME     => array('access_token' => 0, 'client_id' => 1, 'user_id' => 2, 'expires' => 3, 'scope' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('oauth_access_tokens');
        $this->setPhpName('OAuthAccessTokens');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\OAuthAccessTokens');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('access_token', 'AccessToken', 'VARCHAR', true, 40, null);
        $this->addColumn('client_id', 'ClientId', 'VARCHAR', true, 80, null);
        $this->addColumn('user_id', 'UserId', 'VARCHAR', false, 255, null);
        $this->addColumn('expires', 'Expires', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('scope', 'Scope', 'VARCHAR', false, 2000, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('AccessToken', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? OAuthAccessTokensTableMap::CLASS_DEFAULT : OAuthAccessTokensTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (OAuthAccessTokens object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OAuthAccessTokensTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OAuthAccessTokensTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OAuthAccessTokensTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OAuthAccessTokensTableMap::OM_CLASS;
            /** @var OAuthAccessTokens $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OAuthAccessTokensTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = OAuthAccessTokensTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OAuthAccessTokensTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var OAuthAccessTokens $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OAuthAccessTokensTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(OAuthAccessTokensTableMap::COL_ACCESS_TOKEN);
            $criteria->addSelectColumn(OAuthAccessTokensTableMap::COL_CLIENT_ID);
            $criteria->addSelectColumn(OAuthAccessTokensTableMap::COL_USER_ID);
            $criteria->addSelectColumn(OAuthAccessTokensTableMap::COL_EXPIRES);
            $criteria->addSelectColumn(OAuthAccessTokensTableMap::COL_SCOPE);
        } else {
            $criteria->addSelectColumn($alias . '.access_token');
            $criteria->addSelectColumn($alias . '.client_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.expires');
            $criteria->addSelectColumn($alias . '.scope');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(OAuthAccessTokensTableMap::DATABASE_NAME)->getTable(OAuthAccessTokensTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(OAuthAccessTokensTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(OAuthAccessTokensTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new OAuthAccessTokensTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a OAuthAccessTokens or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or OAuthAccessTokens object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OAuthAccessTokensTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \OAuthAccessTokens) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OAuthAccessTokensTableMap::DATABASE_NAME);
            $criteria->add(OAuthAccessTokensTableMap::COL_ACCESS_TOKEN, (array) $values, Criteria::IN);
        }

        $query = OAuthAccessTokensQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            OAuthAccessTokensTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                OAuthAccessTokensTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the oauth_access_tokens table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OAuthAccessTokensQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OAuthAccessTokens or Criteria object.
     *
     * @param mixed               $criteria Criteria or OAuthAccessTokens object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OAuthAccessTokensTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OAuthAccessTokens object
        }


        // Set the correct dbName
        $query = OAuthAccessTokensQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // OAuthAccessTokensTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OAuthAccessTokensTableMap::buildTableMap();
