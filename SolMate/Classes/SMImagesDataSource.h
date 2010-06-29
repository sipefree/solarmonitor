//
//  SMImagesDataSource.h
//  SolMate
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "JSONDataSource.h"
#import "SMImageLoader.h"


@interface SMImagesDataSource : JSONDataSource <SMImageLoaderDelegate> {
	// a dictionary of images where each key is a unique tag given to an image
	// that is to be loaded
	NSMutableDictionary* preloadedImages;
	
	// an instance of the class that can load multiple images asynchronously
	SMImageLoader* loader;
}
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate;

// returns the URLs of thumbnails loaded by the SMImageLoader
- (NSArray *)thumbnails;

// causes the data source to load the thumbnails
- (void)preloadImages;

@property (nonatomic, readonly) NSMutableDictionary* preloadedImages;
@end
