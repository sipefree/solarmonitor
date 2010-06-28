//
//  SMImageLoader.h
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

@protocol SMImageLoaderDelegate;

@interface SMImageLoader : NSObject {
	NSMutableDictionary* preloadedImages;
	CFMutableDictionaryRef connectionToInfoMapping;
	id <SMImageLoaderDelegate> delegate;
	int loadedCount;
	int totalCount;
}
- (id)initWithDictionary:(NSMutableDictionary *)dict delegate:(id <SMImageLoaderDelegate>)anObject;
- (void)loadImagesFromKeysAndURLs:(NSDictionary*)dict;
- (void)cancel;
@end

@protocol SMImageLoaderDelegate

- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total;
- (void)imageLoaderDidComplete:(SMImageLoader*)sender;

@end

