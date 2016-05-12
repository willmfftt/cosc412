<?php

namespace Base;

use \DodPermissions as ChildDodPermissions;
use \DodPermissionsQuery as ChildDodPermissionsQuery;
use \Exception;
use \PDO;
use Map\DodPermissionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dod_permissions' table.
 *
 *
 *
 * @method     ChildDodPermissionsQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildDodPermissionsQuery orderByLft($order = Criteria::ASC) Order by the Lft column
 * @method     ChildDodPermissionsQuery orderByRght($order = Criteria::ASC) Order by the Rght column
 * @method     ChildDodPermissionsQuery orderByTitle($order = Criteria::ASC) Order by the Title column
 * @method     ChildDodPermissionsQuery orderByDescription($order = Criteria::ASC) Order by the Description column
 *
 * @method     ChildDodPermissionsQuery groupById() Group by the ID column
 * @method     ChildDodPermissionsQuery groupByLft() Group by the Lft column
 * @method     ChildDodPermissionsQuery groupByRght() Group by the Rght column
 * @method     ChildDodPermissionsQuery groupByTitle() Group by the Title column
 * @method     ChildDodPermissionsQuery groupByDescription() Group by the Description column
 *
 * @method     ChildDodPermissionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDodPermissionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDodPermissionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDodPermissionsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDodPermissionsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDodPermissionsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDodPermissions findOne(ConnectionInterface $con = null) Return the first ChildDodPermissions matching the query
 * @method     ChildDodPermissions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDodPermissions matching the query, or a new ChildDodPermissions object populated from the query conditions when no match is found
 *
 * @method     ChildDodPermissions findOneById(int $ID) Return the first ChildDodPermissions filtered by the ID column
 * @method     ChildDodPermissions findOneByLft(int $Lft) Return the first ChildDodPermissions filtered by the Lft column
 * @method     ChildDodPermissions findOneByRght(int $Rght) Return the first ChildDodPermissions filtered by the Rght column
 * @method     ChildDodPermissions findOneByTitle(string $Title) Return the first ChildDodPermissions filtered by the Title column
 * @method     ChildDodPermissions findOneByDescription(string $Description) Return the first ChildDodPermissions filtered by the Description column *

 * @method     ChildDodPermissions requirePk($key, ConnectionInterface $con = null) Return the ChildDodPermissions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodPermissions requireOne(ConnectionInterface $con = null) Return the first ChildDodPermissions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDodPermissions requireOneById(int $ID) Return the first ChildDodPermissions filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodPermissions requireOneByLft(int $Lft) Return the first ChildDodPermissions filtered by the Lft column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodPermissions requireOneByRght(int $Rght) Return the first ChildDodPermissions filtered by the Rght column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodPermissions requireOneByTitle(string $Title) Return the first ChildDodPermissions filtered by the Title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodPermissions requireOneByDescription(string $Description) Return the first ChildDodPermissions filtered by the Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDodPermissions[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDodPermissions objects based on current ModelCriteria
 * @method     ChildDodPermissions[]|ObjectCollection findById(int $ID) Return ChildDodPermissions objects filtered by the ID column
 * @method     ChildDodPermissions[]|ObjectCollection findByLft(int $Lft) Return ChildDodPermissions objects filtered by the Lft column
 * @method     ChildDodPermissions[]|ObjectCollection findByRght(int $Rght) Return ChildDodPermissions objects filtered by the Rght column
 * @method     ChildDodPermissions[]|ObjectCollection findByTitle(string $Title) Return ChildDodPermissions objects filtered by the Title column
 * @method     ChildDodPermissions[]|ObjectCollection findByDescription(string $Description) Return ChildDodPermissions objects filtered by the Description column
 * @method     ChildDodPermissions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DodPermissionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DodPermissionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DodPermissions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDodPermissionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDodPermissionsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDodPermissionsQuery) {
            return $criteria;
        }
        $query = new ChildDodPermissionsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDodPermissions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DodPermissionsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DodPermissionsTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDodPermissions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Lft, Rght, Title, Description FROM dod_permissions WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDodPermissions $obj */
            $obj = new ChildDodPermissions();
            $obj->hydrate($row);
            DodPermissionsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDodPermissions|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DodPermissionsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DodPermissionsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ID = 1234
     * $query->filterById(array(12, 34)); // WHERE ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ID > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DodPermissionsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DodPermissionsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DodPermissionsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Lft column
     *
     * Example usage:
     * <code>
     * $query->filterByLft(1234); // WHERE Lft = 1234
     * $query->filterByLft(array(12, 34)); // WHERE Lft IN (12, 34)
     * $query->filterByLft(array('min' => 12)); // WHERE Lft > 12
     * </code>
     *
     * @param     mixed $lft The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterByLft($lft = null, $comparison = null)
    {
        if (is_array($lft)) {
            $useMinMax = false;
            if (isset($lft['min'])) {
                $this->addUsingAlias(DodPermissionsTableMap::COL_LFT, $lft['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lft['max'])) {
                $this->addUsingAlias(DodPermissionsTableMap::COL_LFT, $lft['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DodPermissionsTableMap::COL_LFT, $lft, $comparison);
    }

    /**
     * Filter the query on the Rght column
     *
     * Example usage:
     * <code>
     * $query->filterByRght(1234); // WHERE Rght = 1234
     * $query->filterByRght(array(12, 34)); // WHERE Rght IN (12, 34)
     * $query->filterByRght(array('min' => 12)); // WHERE Rght > 12
     * </code>
     *
     * @param     mixed $rght The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterByRght($rght = null, $comparison = null)
    {
        if (is_array($rght)) {
            $useMinMax = false;
            if (isset($rght['min'])) {
                $this->addUsingAlias(DodPermissionsTableMap::COL_RGHT, $rght['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rght['max'])) {
                $this->addUsingAlias(DodPermissionsTableMap::COL_RGHT, $rght['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DodPermissionsTableMap::COL_RGHT, $rght, $comparison);
    }

    /**
     * Filter the query on the Title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE Title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE Title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DodPermissionsTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE Description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE Description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DodPermissionsTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDodPermissions $dodPermissions Object to remove from the list of results
     *
     * @return $this|ChildDodPermissionsQuery The current query, for fluid interface
     */
    public function prune($dodPermissions = null)
    {
        if ($dodPermissions) {
            $this->addUsingAlias(DodPermissionsTableMap::COL_ID, $dodPermissions->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dod_permissions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DodPermissionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DodPermissionsTableMap::clearInstancePool();
            DodPermissionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DodPermissionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DodPermissionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DodPermissionsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DodPermissionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DodPermissionsQuery
