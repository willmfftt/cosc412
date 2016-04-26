<?php

namespace Base;

use \OAuthRefreshTokens as ChildOAuthRefreshTokens;
use \OAuthRefreshTokensQuery as ChildOAuthRefreshTokensQuery;
use \Exception;
use \PDO;
use Map\OAuthRefreshTokensTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'oauth_refresh_tokens' table.
 *
 *
 *
 * @method     ChildOAuthRefreshTokensQuery orderByRefreshToken($order = Criteria::ASC) Order by the refresh_token column
 * @method     ChildOAuthRefreshTokensQuery orderByClientId($order = Criteria::ASC) Order by the client_id column
 * @method     ChildOAuthRefreshTokensQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildOAuthRefreshTokensQuery orderByExpires($order = Criteria::ASC) Order by the expires column
 * @method     ChildOAuthRefreshTokensQuery orderByScope($order = Criteria::ASC) Order by the scope column
 *
 * @method     ChildOAuthRefreshTokensQuery groupByRefreshToken() Group by the refresh_token column
 * @method     ChildOAuthRefreshTokensQuery groupByClientId() Group by the client_id column
 * @method     ChildOAuthRefreshTokensQuery groupByUserId() Group by the user_id column
 * @method     ChildOAuthRefreshTokensQuery groupByExpires() Group by the expires column
 * @method     ChildOAuthRefreshTokensQuery groupByScope() Group by the scope column
 *
 * @method     ChildOAuthRefreshTokensQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOAuthRefreshTokensQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOAuthRefreshTokensQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOAuthRefreshTokensQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOAuthRefreshTokensQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOAuthRefreshTokensQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOAuthRefreshTokens findOne(ConnectionInterface $con = null) Return the first ChildOAuthRefreshTokens matching the query
 * @method     ChildOAuthRefreshTokens findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOAuthRefreshTokens matching the query, or a new ChildOAuthRefreshTokens object populated from the query conditions when no match is found
 *
 * @method     ChildOAuthRefreshTokens findOneByRefreshToken(string $refresh_token) Return the first ChildOAuthRefreshTokens filtered by the refresh_token column
 * @method     ChildOAuthRefreshTokens findOneByClientId(string $client_id) Return the first ChildOAuthRefreshTokens filtered by the client_id column
 * @method     ChildOAuthRefreshTokens findOneByUserId(string $user_id) Return the first ChildOAuthRefreshTokens filtered by the user_id column
 * @method     ChildOAuthRefreshTokens findOneByExpires(string $expires) Return the first ChildOAuthRefreshTokens filtered by the expires column
 * @method     ChildOAuthRefreshTokens findOneByScope(string $scope) Return the first ChildOAuthRefreshTokens filtered by the scope column *

 * @method     ChildOAuthRefreshTokens requirePk($key, ConnectionInterface $con = null) Return the ChildOAuthRefreshTokens by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOAuthRefreshTokens requireOne(ConnectionInterface $con = null) Return the first ChildOAuthRefreshTokens matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOAuthRefreshTokens requireOneByRefreshToken(string $refresh_token) Return the first ChildOAuthRefreshTokens filtered by the refresh_token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOAuthRefreshTokens requireOneByClientId(string $client_id) Return the first ChildOAuthRefreshTokens filtered by the client_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOAuthRefreshTokens requireOneByUserId(string $user_id) Return the first ChildOAuthRefreshTokens filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOAuthRefreshTokens requireOneByExpires(string $expires) Return the first ChildOAuthRefreshTokens filtered by the expires column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOAuthRefreshTokens requireOneByScope(string $scope) Return the first ChildOAuthRefreshTokens filtered by the scope column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOAuthRefreshTokens[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOAuthRefreshTokens objects based on current ModelCriteria
 * @method     ChildOAuthRefreshTokens[]|ObjectCollection findByRefreshToken(string $refresh_token) Return ChildOAuthRefreshTokens objects filtered by the refresh_token column
 * @method     ChildOAuthRefreshTokens[]|ObjectCollection findByClientId(string $client_id) Return ChildOAuthRefreshTokens objects filtered by the client_id column
 * @method     ChildOAuthRefreshTokens[]|ObjectCollection findByUserId(string $user_id) Return ChildOAuthRefreshTokens objects filtered by the user_id column
 * @method     ChildOAuthRefreshTokens[]|ObjectCollection findByExpires(string $expires) Return ChildOAuthRefreshTokens objects filtered by the expires column
 * @method     ChildOAuthRefreshTokens[]|ObjectCollection findByScope(string $scope) Return ChildOAuthRefreshTokens objects filtered by the scope column
 * @method     ChildOAuthRefreshTokens[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OAuthRefreshTokensQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\OAuthRefreshTokensQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\OAuthRefreshTokens', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOAuthRefreshTokensQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOAuthRefreshTokensQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOAuthRefreshTokensQuery) {
            return $criteria;
        }
        $query = new ChildOAuthRefreshTokensQuery();
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
     * @return ChildOAuthRefreshTokens|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OAuthRefreshTokensTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OAuthRefreshTokensTableMap::DATABASE_NAME);
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
     * @return ChildOAuthRefreshTokens A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT refresh_token, client_id, user_id, expires, scope FROM oauth_refresh_tokens WHERE refresh_token = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildOAuthRefreshTokens $obj */
            $obj = new ChildOAuthRefreshTokens();
            $obj->hydrate($row);
            OAuthRefreshTokensTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOAuthRefreshTokens|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_REFRESH_TOKEN, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_REFRESH_TOKEN, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the refresh_token column
     *
     * Example usage:
     * <code>
     * $query->filterByRefreshToken('fooValue');   // WHERE refresh_token = 'fooValue'
     * $query->filterByRefreshToken('%fooValue%'); // WHERE refresh_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $refreshToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByRefreshToken($refreshToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($refreshToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $refreshToken)) {
                $refreshToken = str_replace('*', '%', $refreshToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_REFRESH_TOKEN, $refreshToken, $comparison);
    }

    /**
     * Filter the query on the client_id column
     *
     * Example usage:
     * <code>
     * $query->filterByClientId('fooValue');   // WHERE client_id = 'fooValue'
     * $query->filterByClientId('%fooValue%'); // WHERE client_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByClientId($clientId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientId)) {
                $clientId = str_replace('*', '%', $clientId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_CLIENT_ID, $clientId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId('fooValue');   // WHERE user_id = 'fooValue'
     * $query->filterByUserId('%fooValue%'); // WHERE user_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userId)) {
                $userId = str_replace('*', '%', $userId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the expires column
     *
     * Example usage:
     * <code>
     * $query->filterByExpires('2011-03-14'); // WHERE expires = '2011-03-14'
     * $query->filterByExpires('now'); // WHERE expires = '2011-03-14'
     * $query->filterByExpires(array('max' => 'yesterday')); // WHERE expires > '2011-03-13'
     * </code>
     *
     * @param     mixed $expires The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByExpires($expires = null, $comparison = null)
    {
        if (is_array($expires)) {
            $useMinMax = false;
            if (isset($expires['min'])) {
                $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_EXPIRES, $expires['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expires['max'])) {
                $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_EXPIRES, $expires['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_EXPIRES, $expires, $comparison);
    }

    /**
     * Filter the query on the scope column
     *
     * Example usage:
     * <code>
     * $query->filterByScope('fooValue');   // WHERE scope = 'fooValue'
     * $query->filterByScope('%fooValue%'); // WHERE scope LIKE '%fooValue%'
     * </code>
     *
     * @param     string $scope The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function filterByScope($scope = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($scope)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $scope)) {
                $scope = str_replace('*', '%', $scope);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_SCOPE, $scope, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOAuthRefreshTokens $oAuthRefreshTokens Object to remove from the list of results
     *
     * @return $this|ChildOAuthRefreshTokensQuery The current query, for fluid interface
     */
    public function prune($oAuthRefreshTokens = null)
    {
        if ($oAuthRefreshTokens) {
            $this->addUsingAlias(OAuthRefreshTokensTableMap::COL_REFRESH_TOKEN, $oAuthRefreshTokens->getRefreshToken(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the oauth_refresh_tokens table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OAuthRefreshTokensTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OAuthRefreshTokensTableMap::clearInstancePool();
            OAuthRefreshTokensTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OAuthRefreshTokensTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OAuthRefreshTokensTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OAuthRefreshTokensTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OAuthRefreshTokensTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OAuthRefreshTokensQuery
