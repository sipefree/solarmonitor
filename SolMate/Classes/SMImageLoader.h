//
//  SMImageLoader.h
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <Foundation/Foundation.h>

@protocol SMImageLoaderDelegate;

@interface SMImageLoader : NSObject {
	// a link to the dictionary of images that the user of this image
	// loader stores its images in. this is never created by the image
	// loader, but shared between them
	NSMutableDictionary* preloadedImages;
	
	// a dictionary where each key is a url connection and each value
	// is the metadata associated with it.
	CFMutableDictionaryRef connectionToInfoMapping;
	
	// an object that will receive notifications about changes in the
	// state of the image loader
	id <SMImageLoaderDelegate> delegate;
	
	// counters for keeping track of progress
	int loadedCount;
	int totalCount;
}
- (id)initWithDictionary:(NSMutableDictionary *)dict delegate:(id <SMImageLoaderDelegate>)anObject;

// loads the images at the URLs in the values of this dictionary, storing the
// keys associated with them in the metadata for the url connection dispatched
- (void)loadImagesFromKeysAndURLs:(NSDictionary*)dict;

// cancels all the url connections and flushes the preloadedImages container
- (void)cancel;

- (void)flush;
@end

@protocol SMImageLoaderDelegate

- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total;
- (void)imageLoaderDidComplete:(SMImageLoader*)sender;

@end

