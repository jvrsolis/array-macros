# Arr-Macros
A list of array macros for laravel with functions found across the web and some I created. 
These macros also contain laravel's collection functions converted into array function macros.
The purpose of making this file is to remove the Collection wrapper class in cases when the user just wants the functionality
that Collections provide without having ot worry when to convert at any point of their application.

## Some caveats: 
	The reason on wants to use Collections is to be able to chain methods and have the original or modified array stored as a property to be readily accessible. 
	You lose these abilities by using just the Arr helper class.
	The Arr helper does not store the array in itself so no chaining can be done. 
	The Arr helper just has predefined functions that the array goes through to be transformed.
	The Arr helper has all static methods.
	To mimic chaining you must pass the array from one function to another yourself.
	Most of the methods below require an array as the initial input and will output an array, no collections.
	Some of these methods are not tested and during their conversion from Collection to Arr there may have been an error.
	PLEASE LET ME KNOW OF ANY ERRORS IN FUNCTIONALITY SO THAT I MAY UPDATE THIS FILE AND OTHERS CAN BENEFIT FROM THIS.

# Functions

	Arr::search : Search the array for a given value and return the corresponding key if successful.
	Arr::searchRobust : Get all keys from a variable dimensional array for a given value at any depth at any occurance and however many you choose.
	Arr::whereOperation : Filter items by the given key value pair.
	Arr::whereStrict : Filter items by the given key value pair using strict comparison.
	Arr::whereIn : Filter items by the given key value pair.
	Arr::whereInStrict : Filter items by the given key value pair using strict comparison.
	Arr::whereNotIn : Filter items by the given key value pair.
	Arr::whereNotInStrict : Filter items by the given key value pair using strict comparison.
	Arr::filter : Run a filter over each of the items.
	Arr::unique : Return only unique items from the array.
	Arr::uniqueStrict : Return only unique items from the array array using strict comparison.
	Arr::reject : Create a array of all elements that do not pass a given truth test.
	Arr::except :  Get all items except for those with the specified keys.
	Arr::exceptNull : Get all items except for those containing null values.
	Arr::exceptEmpty : Get all items except for those containing empty values.
	Arr::only : Get a subset of the items from the given array.
	Arr::sort : Sort through each item with a callback.
	Arr::sortBy : Sort the array using the given callback.
	Arr::sortByDesc : Sort the array in descending order using the given callback.
	Arr::sortMulti : Sort through a multidimensional array by keys and values.
	Arr::sortByMany : Sort using many different keys.
	Arr::mergeSort : Sort using the merge sort algorithm.
	Arr::quickSort : Sort using the quick sort algorithm.
	Arr::bubbleSort : Sort using the bubble sort algorithm.
	Arr::bidirectionalBubbleSort : Sort using the bidirectional sort algorithm.
	Arr::insertionSort : Sort using the insertion sort algorithm.
	Arr::selectionSort : Sort using the selection sort algorithm.
	Arr::shellSort : Sort using the shell sort algorithm.
	Arr::cocktailSort : Sort using the cocktail sort algorithm.
	Arr::combSort : Sort using the comb sort algorithm.
	Arr::gnomeSort : Sort using the gnome sort algorithm.
	Arr::countingSort : Sort using the counting sort algorithm.
	Arr::radixSort : Sort using the radix sort algorithm.
	Arr::beadSort : Sort using the bead sort algorithm.
	Arr::bogoSort : Sort using the bogo sort algorithm.
	Arr::checkSort : Sort using the check sort algorithm.
	Arr::groupBy : Group an associative array by a field or using a callback.
	Arr::groupMany : Group an associative array by many fields or callbacks.
	Arr::ungroup : Ungroup a previously grouped array (grouped by {@see Arr::groupBy()})
	Arr::avg : Get the average value of a given key.
	Arr::average : Alias for the "avg" method.
	Arr::count : Count the number of items in the collection.
	Arr::sum : Get the sum of the given values.
	Arr::max : Get the max value of a given array.
	Arr::min : Get the min value of a given array.
	Arr::mode : Get the mode of a given array.
	Arr::median : Get the median of a given array.
	Arr::range : Create a new array instance with a range of numbers.
	Arr::aggregate : Call an aggregate function on an array. (Sum, max, min, etc)
	Arr::tap : Pass the array to the given callback and then return it.
	Arr::when : Apply the callback if the value is truthy.
	Arr::unless : Apply the callback if the value is falsy.
	Arr::ifEmpty : Execute a callable if the array is empty, then return the collection.
	Arr::ifAny : Execute a callable if the array isn't empty, then return the collection.
	Arr::map : Run a map over each of the items.
	Arr::mapWithKeys : Run an associative map over each of the items.
	Arr::mapSpread : Run a map over each nested chunk of items.
	Arr::mapToGroups : Run a grouping map over the items.
	Arr::mapToAssoc : Map an array to associative key value pairings.
	Arr::flatMap : Map an array and flatten the result by a single level.
	Arr::filterMap : Map an array and filter the results.
	Arr::pluck : Pluck an array of values from an array.
	Arr::values : Reset the keys on the underlying array.
	Arr::keys : Get the keys of the array items.
	Arr::keyBy : Key an associative array by a field or using a callback.
	Arr::times : Create a new array by invoking the callback a given number of times.
	Arr::each : Execute a callback over each item.
	Arr::eachSpread : Execute a callback over each nested chunk of items.
	Arr::first : Get the first item from the array or the first value after a callback is executed on the array.
	Arr::last : Get the last item from the array or the lsat value after a callback is executed on the array.
	Arr::after : Get the next item from the array.
	Arr::before : Get the previous item from the array.
	Arr::take : Take the first or last {$limit} items.
	Arr::reduce : Reduce the array to a single value.
	Arr::slice : Slice the underlying array.
	Arr::sliceAssoc : Slice the underlying array using associative keys.
	Arr::splice : Splice a portion of the underlying array.
	Arr::split : Split a array into a certain number of groups.
	Arr::partition : Partition the array into two arrays using the given callback or key.
	Arr::nth : Create a new array consisting of every n-th element.
	Arr::chunk : Chunk the underlying array.
	Arr::transform : Determine if the given value is callable, but not a string.
	Arr::permutations : Returns all possible permutations. The resulting array will always have pow(count($values), $n) values
	Arr::combinations : Returns all possible combinations.
	Arr::balance : Equalize the size of two arrays.
	Arr::rotate : Rotate the items of the array, return the last item.
	Arr::shuffle : Shuffle the items in the collection.
	Arr::random : Get one or a specified number of random values from an array.
	Arr::occurances : Returns an associative array of values from array as keys and their count as value.
	Arr::depth : Return the depth of the array.
	Arr::swapPositions : Swap the position of two elements in the array (used in sorting algorithm)
	Arr::reverse : Reverse items order.
	Arr::reverseKeys : Reverse keys of an array.
	Arr::flip : Flip the items in the array.
	Arr::transpose : Transpose a array. Rows become columns, columns become rows.
	Arr::transposeWithKeys : Transpose an array while keeping its columns and row headers intact.
	Arr::transposeStrict : Transpose an array strictly. (Length errors are thrown)
	Arr::crossJoin : Cross join the given arrays.
	Arr::innerJoin : Inner join the given arrays.
	Arr::outerJoin : Outer join the given arrays.
	Arr::union : Obtain the true union two arrays.
		EXP:: In a venn diagram between A and B, this function returns all values found exclusively in A and exclusively in B 
		and values shared between A and B. 
		(All Venn Diagram)
	Arr::intersection : Obtain the true intersection of two arrays.
		EXP:: In a venn diagram between A and B, this function returns all values shared between A and B. 
		(Center Venn Diagram)
	Arr::difference : Obtain the true difference of two arrays.
		EXP:: In a venn diagram between A and B, this function returns exclusive values of both A and B, but 
		not values shared between A and B. 
		(Left and Right Only Venn Diagram)
	Arr::rightDifference : Obtain the true right difference of two arrays.
		EXP:: In a venn diagram between A and B, this function returns values found exclusively in B, 
		but not values shared between A and B. 
		(Right Only Venn Diagram)
	Arr::rightUnion : Obtain the true right union of two arrays.
		EXP:: In a venn diagram between A and B, this function returns all values found exclusively in A and
     	values shared between A and B. 
		(Right and Center of Venn Diagram)
	Arr::leftDifference : Obtain the true left difference.
		In a venn diagram between A and B, this function returns values found exclusively in A, but not
     	values shared between A and B.
		(Left Only Venn Diagram)
	Arr::leftUnion : Obtain the true left union.
		In a venn diagram between A and B, this function returns all values found exclusively in A and and
    	commonly shared values.
     	(Left and Center of Venn Diagram)
	Arr::intesect : Intersect the array with the given items.
	Arr::intersectKeys : Intersect the array with the given items by key.
	Arr::diff : Get the items in the array that are not present in the given items.
	Arr::diffAssoc : Get the items in the array whose keys and values are not present in the given items.
	Arr::diffKeys : Get the items in the array whose keys are not present in the given items.
	Arr::merge :  Merge the array with the given items.
	Arr::mergeFlatMap : Merge the array after a flat map, preserving the keys.
	Arr::concat : Push all of the given items onto the array.
	Arr::combine : Create a array by using this array for keys and another for its values.
	Arr::divide : Divide an array into two arrays. One with keys and the other with values.
	Arr::zip : Zip the array together with one or more arrays.
	Arr::flatten : Flatten a multi-dimensional array into a single level.
	Arr::collapse : Collapse an array of arrays into a single array.
	Arr::collapseWitKeys : Collapse an array of arrays into a single array, avoids using array_merge to preserve the keys.
	Arr::implode : Concatenate values of an array.
	Arr::implodeWithKeys : Concatenate values of a given key as a string.
	Arr::implodeMulti : Concatenate values of a given key as a string in a multidimensional array.
	Arr::uppercase : Map all items to uppercase.
	Arr::isAccessible : Determine whether the given value is array accessible.
	Arr::isAssoc : Determines if an array is associative.
	Arr::isIndexed : Returns a value indicating whether the given array is an indexed array.
	Arr::isMulti : Determines if an array is multidimensional.
	Arr::isEmpty : Determines if the array is empty or not.
	Arr::isNotEmpty : Determine if the array is not empty.
	Arr::has : Check if an item or items exist in an array using "dot" notation.
	Arr::contains : Determine if an item exists in the array.
	Arr::containsStrict : Determine if an item exists in the array using strict comparison.
	Arr::every : Determine if all items in the array pass the given test.
	Arr::paginate : Paginate the given array.
	Arr::simplePaginate : Paginate the array into a simple paginator
	Arr::forPage : "Paginate" the array by slicing it into a smaller array.
	Arr::toSet : Converts a model array into a dataset.
	Arr::toSeries : Converts a model array into a multi-dataset series. 
	Arr::toArray : Get the array of items as a plain array.
	Arr::toJson : Get the array of items as JSON.
	Arr::toString : Convert the array to its string representation.
	Arr::toGeneric : Convert the array to an object.
	Arr::toGenericStrict : Convert the array and all nested arrays into objects.
	Arr::toCollection : Convert the array to a collection.
	Arr::toCollectionStrict : Convert the array and all nested arrays into collections.
	Arr::make : Create an empty array.
	Arr::all : Return all values of the array.
	Arr::add : Add an element to an array using "dot" notation if it doesn't exist.
	Arr::forget : Remove one or many array items from a given array using "dot" notation.
	Arr::put : Put an item in the array by key.
	Arr::push : Push an item onto the end of the array.
	Arr::pull : Get a value from the array, and remove it.
	Arr::pop : Get and remove the last item from the array.
	Arr::shift : Get and remove the first item from the array.
	Arr::prepend : Push an item onto the beginning of an array.
	Arr::get : Get an item from an array using "dot" notation.
	Arr::offsetGet : Get an item at a given offset.
	Arr::set : Set an array item to a given value using "dot" notation.
	Arr::offsetSet : Set the item at a given offset.
	Arr::offsetUnset : Unset the item at a given offset.
	Arr::exists : Determine if the given key exists in the provided array.
	Arr::offsetExists : Determine if an item exists at an offset.
	Arr::dot : Flatten a multi-dimensional associative array with dots.
	Arr::undot : Expands a dotted associative array. The inverse of Arr::dot().
	Arr::wrap : If the given value is not an array, wrap it in one.
	Arr::explodePluckParameters : Explode the "value" and "key" arguments passed to "pluck".
	Arr::jsonSerialize : Convert the object into something JSON serializable.
	Arr::valueRetriever :  Get a value retrieving callback.
	Arr::useAsCallable : Determine if the given value is callable, but not a string.
	Arr::getArrayableItems : Results array of items from array or Arrayable.
	Arr::getCachingIterator : Get a CachingIterator instance.
	Arr::operatorForWhere : Get an operator checker callback.
	Arr::toAssoc : Create an associative keyed array the specified column values of the array.
	Arr::dump : Dump the arguments given followed by the collection.



....
