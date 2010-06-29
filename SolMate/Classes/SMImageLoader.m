//
//  SMImageLoader.m
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMImageLoader.h"


@implementation SMImageLoader
- (id)initWithDictionary:(NSMutableDictionary*)dict delegate:(id <SMImageLoaderDelegate>)anObject {
	if(self == [super init]) {
		// create the dictionary to store url connections
		// and metadata. this is a CFDictionary instead of
		// an NSDictionary because CFDictionary does not try
		// to -copy each of the keys stored, whereas NSDictionary
		// does. this means that URL connections (which cannot be
		// copied) can be used as keys for reverse-lookup
		connectionToInfoMapping =
		CFDictionaryCreateMutable(
								  kCFAllocatorDefault,
								  0,
								  &kCFTypeDictionaryKeyCallBacks,
								  &kCFTypeDictionaryValueCallBacks);
		
		preloadedImages = [dict retain];
		delegate = anObject;
	}
	return self;
}
- (void)loadImagesFromKeysAndURLs:(NSDictionary *)dict {
	NSLog(@"loading images: %@", [dict description]);
	// loop through the dictionary, dispatching url connections for each
	for (NSString* key in [dict allKeys]) {
		// the value of each key in the dictionary is a url
		NSURL* imgUrl = [dict objectForKey:key];
		
		// create the request object
		NSURLRequest* req = [NSURLRequest requestWithURL:imgUrl];
		
		// a dict is created with two keys, one for the key (name) of the 
		// image to be loaded, the other with the data container for the
		// url connection
		// this object is added to the connection dictionary with the url
		// request as the key
		CFDictionaryAddValue(connectionToInfoMapping,
							 [NSURLConnection connectionWithRequest:req delegate:self],
							 [NSMutableDictionary
							  dictionaryWithObjectsAndKeys:[NSMutableData data],@"receivedData",key,@"key",nil]);
	}
	// reset the number of currently loaded images and the total number of images
	loadedCount = 0;
	totalCount = [[dict allKeys] count];
}
- (void)connection:(NSURLConnection *)conn didReceiveResponse:(NSURLResponse *)response {
	// retrieve the data container for this url connection and prepare it for received data
	NSMutableDictionary *connectionInfo = (NSMutableDictionary *)CFDictionaryGetValue(connectionToInfoMapping, conn);
	[[connectionInfo objectForKey:@"receivedData"] setLength:0];
}

- (void)connection:(NSURLConnection *)conn didReceiveData:(NSData *)data {
	// retrieve the data container for this url connection and append received data to it
	NSMutableDictionary *connectionInfo = (NSMutableDictionary *)CFDictionaryGetValue(connectionToInfoMapping, conn);
	[[connectionInfo objectForKey:@"receivedData"] appendData:data];
}

- (void)connection:(NSURLConnection *)conn didFailWithError:(NSError *)error {
	// the app will probably crash anyway
	NSLog(@"%@", [NSString stringWithFormat:@"Connection failed: %@", [error description]]);
}
- (void)connectionDidFinishLoading:(NSURLConnection *)conn {
	// retrieve the metadata for this url connection
	NSMutableDictionary *connectionInfo = (NSMutableDictionary *)CFDictionaryGetValue(connectionToInfoMapping, conn);
	
	// get the name for this image
	NSString* key = [connectionInfo objectForKey:@"key"];
	
	// create the image object from the data container
	UIImage* image = [UIImage imageWithData:[connectionInfo objectForKey:@"receivedData"]];
	
	// if the image failed to load (probably due to a 404), replace it with a placeholder
	if(image != nil)
		[preloadedImages setObject:image forKey:key];
	else
		[preloadedImages setObject:[UIImage imageNamed:@"noData.png"] forKey:key];

	// remove the connection from the dictionary
	CFDictionaryRemoveValue(connectionToInfoMapping, conn);
	
	// increase the number of loaded images
	loadedCount++;
	
	// inform the delegate that a new image is loaded
	[delegate imageLoader:self didProgressWithCount:loadedCount ofTotal:totalCount];
	
	// if there are no more images still loading, inform the delegate that
	// all images have been loaded
	if(CFDictionaryGetCount(connectionToInfoMapping) == 0) {
		[delegate imageLoaderDidComplete:self];
	}
}

// a callback function for cancelling a connection
void SMCancelConnections (const void *key, const void *value, void *context) {
	NSURLConnection* conn = (NSURLConnection*)key;
	[conn cancel];
}
- (void)cancel {
	// apply the cancel callback to all connections in the dictionary
	CFDictionaryApplyFunction(connectionToInfoMapping, &SMCancelConnections, NULL);
}
- (void)flush {
	// free up the preloadedImages dictionary in order to conserve RAM
	[preloadedImages removeAllObjects];
}
- (void)dealloc {
	[preloadedImages release];
	CFRelease(connectionToInfoMapping);
	[super dealloc];
}
@end
