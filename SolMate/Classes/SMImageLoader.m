//
//  SMImageLoader.m
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "SMImageLoader.h"


@implementation SMImageLoader
- (id)initWithDictionary:(NSMutableDictionary*)dict delegate:(id <SMImageLoaderDelegate>)anObject {
	if(self == [super init]) {
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
	for (NSString* key in [dict allKeys]) {
		NSURL* imgUrl = [dict objectForKey:key];
		NSURLRequest* req = [NSURLRequest requestWithURL:imgUrl];
		CFDictionaryAddValue(connectionToInfoMapping,
							 [NSURLConnection connectionWithRequest:req delegate:self],
							 [NSMutableDictionary
							  dictionaryWithObjectsAndKeys:[NSMutableData data],@"receivedData",key,@"key",nil]);
	}
	loadedCount = 0;
	totalCount = [[dict allKeys] count];
}
- (void)connection:(NSURLConnection *)conn didReceiveResponse:(NSURLResponse *)response {
	NSMutableDictionary *connectionInfo = (NSMutableDictionary *)CFDictionaryGetValue(connectionToInfoMapping, conn);
	[[connectionInfo objectForKey:@"receivedData"] setLength:0];
}

- (void)connection:(NSURLConnection *)conn didReceiveData:(NSData *)data {
	NSMutableDictionary *connectionInfo = (NSMutableDictionary *)CFDictionaryGetValue(connectionToInfoMapping, conn);
	[[connectionInfo objectForKey:@"receivedData"] appendData:data];
}

- (void)connection:(NSURLConnection *)conn didFailWithError:(NSError *)error {
	NSLog(@"%@", [NSString stringWithFormat:@"Connection failed: %@", [error description]]);
}
- (void)connectionDidFinishLoading:(NSURLConnection *)conn {
	NSMutableDictionary *connectionInfo = (NSMutableDictionary *)CFDictionaryGetValue(connectionToInfoMapping, conn);
	NSString* key = [connectionInfo objectForKey:@"key"];
	UIImage* image = [UIImage imageWithData:[connectionInfo objectForKey:@"receivedData"]];
	if(image != nil)
		[preloadedImages setObject:image forKey:key];
	else
		[preloadedImages setObject:[UIImage imageNamed:@"noData.png"] forKey:key];

	CFDictionaryRemoveValue(connectionToInfoMapping, conn);
	loadedCount++;
	[delegate imageLoader:self didProgressWithCount:loadedCount ofTotal:totalCount];
	if(CFDictionaryGetCount(connectionToInfoMapping) == 0) {
		[delegate imageLoaderDidComplete:self];
	}
}
void SMCancelConnections (const void *key, const void *value, void *context) {
	NSURLConnection* conn = (NSURLConnection*)key;
	[conn cancel];
}
- (void)cancel {
	CFDictionaryApplyFunction(connectionToInfoMapping, &SMCancelConnections, NULL);
}
- (void)dealloc {
	[preloadedImages release];
	CFRelease(connectionToInfoMapping);
	[super dealloc];
}
@end
